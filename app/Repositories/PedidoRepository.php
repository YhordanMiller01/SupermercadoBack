<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Fruta;
use App\Models\Pedido;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Arr;


/**
 * PedidoRepository Repository.
 *
 * Clase que se utilza para el acceso a los datos
 *
 * @package App
 * @subpackage App\Repositories
 * @author Jhordan Miller<jhojamil92@gmail.com>
 * @version v1.0.0
 */
class PedidoRepository
{
    /**
     * Pedido $model.
     * @var [type]
     */
    private $model;
    /**
     * Constructor de la clase.
     *
     * @param
     */
    public function __construct()
    {
        $this->model = new Pedido();
    }
    /**
     * Traer registros para pintar en la tabla pedidos
     *
     * @access public
     * @return object
     */
    public function index(): object
    {
        return $this->model->all();
    }
    /**
     * Guarda los registros en la tabla pedidos
     *
     * @access public
    *  @param collection $data
    */
    public function savePedido($data) : object
    {

        $total = 0;
        $cantidad_pedido = 0;
        $total_por_fruta = [];

        if(!$this->validarDisponibilidadFrutas($data)) {

            foreach ($data as $track) {
                $tipo  = $track['tipo'];
                $cantidad  = $track['cantidad'];
                $data_fruta = fruta::where("tipo", $tipo)->first();
                $cantidad_pedido = $data_fruta->cantidad - $cantidad;
                $this->updateValorFruta($cantidad_pedido, $tipo);
                $aplica_descuento_cinco = ($cantidad > 10) ? $data_fruta->precio - ($data_fruta->precio * 0.05) : $data_fruta->precio;
                $valor_fruta = $aplica_descuento_cinco * $cantidad;
                $total_por_fruta[] = [$tipo => $valor_fruta];
                $total += $valor_fruta;
            }

            /***se realiza el descuento del 10 sobre el total*/
            if(($this->validarCantidadDiferentesFrutas($data) == count($data)) && count($data) > 5) {
                $descuento = $total / 10;
                $total = $total - $descuento;
            }
            Pedido::create([
                'lista_frutas' => json_encode($data),
                'valor_total' => $total
            ]);

            return response()->json(array(
                'code'      =>  200,
                'error' => false,
                'message'   =>  'Datos guardado exitosamente',
                'total'      =>  $total,
                'total_fruta'   =>  $total_por_fruta,
            ), 200);

        } else {
            return response()->json(array(
                'code'      =>  500,
                'error' => true,
                'message'   =>  'La fruta se encuentra agotada'
            ), 500);
        }
    }

    /**
     * Validar disponibilidad de las frutas en cuanto a cantidad y existencia
     *
     * @param array $data
     * @return boolean
     */
    public function validarDisponibilidadFrutas(array $data) : bool {
        $error = false;
        foreach ($data as $track) {
            $tipo  = $track['tipo'];
            $cantidad  = $track['cantidad'];
            $data_fruta = fruta::where("tipo", $tipo)->first();

            if(empty($data_fruta) || $cantidad > $data_fruta->cantidad){
                $error =true;
            }
        }

        return $error;
    }

    /**
     * Actualiza el la cantidad de la fruta pedida, en la tabla frutas
     *
     * @param integer $cantidad
     * @param string $tipo
     * @return void
     */
    public function updateValorFruta(int $cantidad, string $tipo) : void {
        fruta::where('tipo', $tipo)
            ->update(['cantidad' => $cantidad]);
    }

    /**
     * Valida que la cantidad de frutas no se repitan  y trae la cantidad que no se ha repetido
     *
     * @param array $data
     * @return integer
     */
    public function validarCantidadDiferentesFrutas(array $data): int {

        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($data as $val) {
            $valor = strtolower($val['tipo']);
            if (!in_array($valor, $key_array)) {
                $key_array[$i] = $valor;
                $temp_array[$i] = $val;
            }
            $i++;
        }

        return count($temp_array);
    }
}

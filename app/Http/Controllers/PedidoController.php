<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\PedidoRepository;

class PedidoController extends Controller
{

     /**
     * pedido Repository.
     * @var [type]
     */
    protected $pedido;

    /**
     * Constructor de la clase.
     *
     * @param PedidoRepository $equipo [Dependencia PedidoRepository]
     */
    public function __construct(PedidoRepository $pedido)
    {
        $this->pedido = $pedido;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = $this->pedido->index();

        return response()->json($pedidos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       DB::beginTransaction();
        try {
            $data     =  $request->all();
            $pedido =  $this->pedido->savePedido($data);
            DB::commit();
            return response()->json(array(
                'code'      =>  200,
                'error' => false,
                'message'   =>  'Pedido creado correctamente',
                'data' => $pedido
            ), 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array(
                'code'      =>  500,
                'error' => true,
                'message'   =>  'No se pudo crear el Pedido' .$e
            ), 500);
        }
    }

}

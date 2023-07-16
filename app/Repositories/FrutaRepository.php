<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Fruta;

/**
 * FrutaRepository Repository.
 *
 * Clase que se utilza para el acceso a los datos
 *
 * @package App
 * @subpackage App\Repositories
 * @author Jhordan Miller<jhojamil92@gmail.com>
 * @version v1.0.0
 */
class FrutaRepository
{
    /**
     * Fruta $model.
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
        $this->model = new Fruta();
    }
    /**
     * Traer registros para pintar en la tabla frutas
     *
     * @access public
     * @return object
     */
    public function index(): object
    {
        return $this->model->all();
    }
    /**
     * Guarda los registros en la tabla frutas
     *
     * @access public
    *  @param collection $data
    * @return object
    */
    public function saveFruta($data): object
    {
        $pedido = $this->model->create($data);
        return $pedido;
    }
    /**
     * Actualiza los registros en la tabla Frutas por su id
     *
     * @access public
     * @param collection $data
     * @param integer $id
     * @return bool
     */
    public function update($data, int $id): bool
    {
        return $this->model->findOrFail($id)->update($data);
    }

    /**
     * delete function, eliminar un registro de la tabla frutas por su id
     * @access public
     * @param integer $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->findOrFail($id)->delete();
    }
}

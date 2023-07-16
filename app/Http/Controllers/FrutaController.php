<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FrutaRequest;
use App\Repositories\FrutaRepository;

class FrutaController extends Controller
{


    /**
     * fruta Repository.
     * @var [type]
     */
    protected $fruta;

    /**
     * Constructor de la clase.
     *
     * @param FrutaRepository $equipo [Dependencia FrutaRepository]
     */
    public function __construct(FrutaRepository $fruta)
    {
        $this->fruta = $fruta;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $frutas = $this->fruta->index();

        return response()->json($frutas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FrutaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FrutaRequest $request)
    {
        DB::beginTransaction();
        try {
            $data     =  $request->all();
            $fruta =  $this->fruta->saveFruta($data);
            DB::commit();
            return response()->json(array(
                'code'      =>  200,
                'error' => false,
                'message'   =>  'Fruta creada correctamente',
                'data' => $fruta
            ), 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array(
                'code'      =>  500,
                'error' => true,
                'message'   =>  'No se pudo crear el Fruta'
            ), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $data            = $request->all();
        try {
            $frutaUpdate = $this->fruta->update($data, $id);
            DB::commit();
            return response()->json([
                'code' => 200,
                'error' => '',
                'mensaje' => 'Fruta con  '.$id.' actualizada correctamente',
                'data' => $frutaUpdate,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array(
                'code'      =>  500,
                'error' => true,
                'message'   =>  'No se pudo actualizar la Fruta' . $id
            ), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $frutaDelete = $this->fruta->delete($id);
            DB::commit();
            return response()->json([
                'code' => 200,
                'error' => '',
                'mensaje' => 'Fruta '.$id.' eliminada correctamente',
                'data' => $frutaDelete,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array(
                'code'      =>  500,
                'error' => true,
                'message'   =>  'No se pudo eliminar la Fruta con id' . $id .' o no existe'
            ), 500);
        }
    }
}

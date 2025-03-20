<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnidadRequest;
use App\Http\Requests\UpdateUnidadRequest;
use App\Models\Categoria;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnidadController extends Controller
{
    public $rutaVisita = 'Unidad';
    public function query(Request $request)
    {
        try {
            $queryStr = $request->get('query');
            $responsse = Unidad::where('sigla', 'LIKE', '%' . $queryStr . '%')
                ->orWhere('detalle', 'LIKE', '%' . $queryStr . '%')
                ->orderBy('id', 'ASC')
                ->get();
            $cantidad = count($responsse);
            $str = strval($cantidad);
            return response()->json([
                "isRequest" => true,
                "isSuccess" => true,
                "isMessageError" => false,
                "message" => "$str datos encontrados",
                "messageError" => "",
                "data" => $responsse,
                "statusCode" => 200
            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest" => true,
                "isSuccess" => false,
                "isMessageError" => true,
                "message" => $message,
                "messageError" => "",
                "data" => [],
                "statusCode" => $code
            ]);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render($this->rutaVisita.'/Index', [
            'listado' => Unidad::all(),
            'crear' => true,
            'editar' => true,
            'eliminar' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render($this->rutaVisita.'/CreateUpdate',
            [
                'isCreate' => true,
                'crear' => true,
                'editar' => true,
                'eliminar' => true
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnidadRequest $request)
    {
        try {
            $data = Unidad::create($request->all());
            return response()->json([
                'isRequest' => true,
                'isSuccess' => true,
                'isMessageError' => false,
                'message' => 'Registro guardado correctamente',
                'messageError' => '',
                'data' => $data,
                'statusCode' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'isRequest' => true,
                'isSuccess' => false,
                'isMessageError' => true,
                'message' => 'Error al guardar el registro',
                'messageError' => $e->getMessage(),
                'data' => [],
                'statusCode' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Unidad $unidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unidad $unidad)
    {
        return Inertia::render($this->rutaVisita.'/CreateUpdate', [
            'isCreate' => false,
            'crear' => true,
            'editar' => true,
            'eliminar' => true,
            'model' => $unidad]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnidadRequest $request, Unidad $unidad)
    {
        try {
            $unidad->update($request->all());
            return response()->json([
                'isRequest' => true,
                'isSuccess' => true,
                'isMessageError' => false,
                'message' => 'Registro actualizado correctamente',
                'messageError' => '',
                'model' => $unidad,
                'statusCode' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'isRequest' => true,
                'isSuccess' => false,
                'isMessageError' => true,
                'message' => 'Error al actualizar el registro',
                'messageError' => $e->getMessage(),
                'data' => [],
                'statusCode' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unidad $unidad)
    {
        try {
            $unidad->delete();
            return response()->json([
                'isRequest' => true,
                'isSuccess' => true,
                'isMessageError' => false,
                'message' => 'Registro eliminado correctamente',
                'messageError' => '',
                'data' => [],
                'statusCode' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'isRequest' => true,
                'isSuccess' => false,
                'isMessageError' => true,
                'message' => 'Error al eliminar el registro',
                'messageError' => $e->getMessage(),
                'data' => [],
                'statusCode' => 500
            ], 500);
        }
    }
}

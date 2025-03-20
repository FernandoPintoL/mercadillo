<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlmacenRequest;
use App\Http\Requests\UpdateAlmacenRequest;
use App\Models\Almacen;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlmacenController extends Controller
{
    public string $rutaVisita = 'Almacen';
    public function query(Request $request)
    {
        try {
            $queryStr = $request->get('query');
            $responsse = Almacen::where('sigla', 'LIKE', '%' . $queryStr . '%')
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
            'listado' => Almacen::all(),
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
    public function store(StoreAlmacenRequest $request)
    {
        try {
            $data = Almacen::create($request->all());
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
    public function show(Almacen $almacen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Almacen $almacen)
    {
        return Inertia::render($this->rutaVisita.'/CreateUpdate', [
            'isCreate' => false,
            'crear' => true,
            'editar' => true,
            'eliminar' => true,
            'model' => $almacen]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlmacenRequest $request, Almacen $almacen)
    {
        try {
            $almacen->update($request->all());
            return response()->json([
                'isRequest' => true,
                'isSuccess' => true,
                'isMessageError' => false,
                'message' => 'Registro actualizado correctamente',
                'messageError' => '',
                'model' => $almacen,
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
    public function destroy(Almacen $almacen)
    {
        try {
            $almacen->delete();
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

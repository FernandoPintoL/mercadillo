<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Almacen;
use App\Models\Cliente;
use App\Services\ResponseService;
use Inertia\Inertia;

class ClienteController extends Controller
{

    public string $rutaVisita = 'Cliente';
    public function query(Request $request)
    {
        try {
            $queryStr = $request->get('query');
            $responsse = Cliente::where('sigla', 'LIKE', '%' . $queryStr . '%')
                ->orWhere('detalle', 'LIKE', '%' . $queryStr . '%')
                ->orderBy('id', 'ASC')
                ->get();
            $cantidad = count($responsse);
            $str = strval($cantidad);
            return ResponseService::success("$str datos encontrados", $responsse);
        } catch (\Exception $e) {
            return ResponseService::error($e->getMessage(), '', $e->getCode());
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render($this->rutaVisita.'/Index', [
            'listado' => Cliente::all(),
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
    public function store(StoreClienteRequest $request)
    {
        try {
            $data = Cliente::create($request->all());
            return ResponseService::success('Registro guardado correctamente', $data);
        } catch (\Exception $e) {
            return ResponseService::error('Error al guardar el registro', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return Inertia::render($this->rutaVisita.'/CreateUpdate', [
            'isCreate' => false,
            'crear' => true,
            'editar' => true,
            'eliminar' => true,
            'model' => $cliente]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        try {
            $cliente->update($request->all());
            return ResponseService::success('Registro actualizado correctamente', $cliente);
        } catch (\Exception $e) {
            return ResponseService::error('Error al actualizar el registro', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();
            return ResponseService::success('Registro eliminado correctamente');
        } catch (\Exception $e) {
            return ResponseService::error('Error al eliminar el registro', $e->getMessage());
        }
    }
}

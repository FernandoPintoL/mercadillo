<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use App\Services\PermissionService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriaController extends Controller
{
    public $rutaVisita = 'Categoria';
    public function query(Request $request)
    {
        try {
            $queryStr = $request->get('query');
            $responsse = Categoria::where('sigla', 'LIKE', '%' . $queryStr . '%')
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
        return Inertia::render($this->rutaVisita . '/Index', array_merge([
            'listado' => Categoria::all(),
        ], PermissionService::getPermissions($this->rutaVisita)));
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
    public function store(StoreCategoriaRequest $request)
    {
        try {
            $data = Categoria::create($request->all());
            return ResponseService::success('Registro guardado correctamente', $data);
        } catch (\Exception $e) {
            return ResponseService::error('Error al guardar el registro', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categorium)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categorium)
    {
        return Inertia::render($this->rutaVisita.'/CreateUpdate', [
            'isCreate' => false,
            'crear' => true,
            'editar' => true,
            'eliminar' => true,
            'model' => $categorium]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categorium)
    {
        try {
            $categorium->update($request->all());
            return ResponseService::success('Registro actualizado correctamente', $categorium);
        } catch (\Exception $e) {
            return ResponseService::error('Error al actualizar el registro', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categorium)
    {
        try {
            $categorium->delete();
            return ResponseService::success('Registro eliminado correctamente');
        } catch (\Exception $e) {
            return ResponseService::error('Error al eliminar el registro', $e->getMessage());
        }
    }
}

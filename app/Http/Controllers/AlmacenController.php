<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlmacenRequest;
use App\Http\Requests\UpdateAlmacenRequest;
use App\Models\Almacen;
use App\Services\PermissionService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AlmacenController extends Controller
{
    public function __construct()
    {
        /*$this->middleware('permission:almacen-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:almacen-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:almacen-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:almacen-delete', ['only' => ['destroy']]);*/
    }
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
            'listado' => Almacen::all(),
        ], PermissionService::getPermissions($this->rutaVisita)));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Verificar permiso manualmente
        if (!Auth::user()->can('create Cliente')) {
            abort(403);
        }
        return Inertia::render($this->rutaVisita . '/CreateUpdate', array_merge([
            'isCreate' => true,
            'listado' => Almacen::all(),
        ], PermissionService::getPermissions($this->rutaVisita)));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlmacenRequest $request)
    {
        try {
            $data = Almacen::create($request->all());
            return ResponseService::success('Registro guardado correctamente', $data);
        } catch (\Exception $e) {
            return ResponseService::error('Error al guardar el registro', $e->getMessage());
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
        // Verificar permiso manualmente
        if (!Auth::user()->can('edit Cliente')) {
            abort(403);
        }
        return Inertia::render($this->rutaVisita . '/CreateUpdate', array_merge([
            'isCreate' => false,
            'model' => $almacen,
        ], PermissionService::getPermissions($this->rutaVisita)));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlmacenRequest $request, Almacen $almacen)
    {
        try {
            $almacen->update($request->all());
            return ResponseService::success('Registro actualizado correctamente', $almacen);
        } catch (\Exception $e) {
            return ResponseService::error('Error al actualizar el registro', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Almacen $almacen)
    {
        try {
            $almacen->delete();
            return ResponseService::success('Registro eliminado correctamente');
        } catch (\Exception $e) {
            return ResponseService::error('Error al eliminar el registro', $e->getMessage());
        }
    }
}

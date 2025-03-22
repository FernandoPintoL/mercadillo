<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpleadoCargoRequest;
use App\Http\Requests\UpdateEmpleadoCargoRequest;
use App\Models\Almacen;
use App\Models\Empleado;
use App\Models\EmpleadoCargo;
use App\Services\ResponseService;
use Inertia\Inertia;

class EmpleadoCargoController extends Controller
{
    public string $rutaVisita = 'Empleado';
    public function query(Request $request)
    {
        try {
            $queryStr = $request->get('query');
            $responsse = Empleado::where('sigla', 'LIKE', '%' . $queryStr . '%')
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
        return Inertia::render($this->rutaVisita . '/Index', [
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmpleadoCargoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EmpleadoCargo $empleadoCargo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmpleadoCargo $empleadoCargo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmpleadoCargoRequest $request, EmpleadoCargo $empleadoCargo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmpleadoCargo $empleadoCargo)
    {
        //
    }
}

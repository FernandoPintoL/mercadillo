<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\{
    AlmacenController,
    CategoriaController,
    ClienteController,
    EmpleadoController,
    EmpleadoCargoController,
    EmpresaController,
    InventarioController,
    ItemController,
    MenuController,
    PermissionsController,
    ProveedorController,
    RolesController,
    SectorController,
    TipoDocumentoController,
    UnidadController
};

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

$resources = [
    'almacen' => AlmacenController::class,
    'categoria' => CategoriaController::class,
    'cliente' => ClienteController::class,
    'empleado' => EmpleadoController::class,
    'empleado-cargo' => EmpleadoCargoController::class,
    'empresa' => EmpresaController::class,
    'inventario' => InventarioController::class,
    'item' => ItemController::class,
    'menu' => MenuController::class,
    'permissions' => PermissionsController::class,
    'proveedor' => ProveedorController::class,
    'roles' => RolesController::class,
    'sector' => SectorController::class,
    'tipo-documento' => TipoDocumentoController::class,
    'unidad' => UnidadController::class,
];

foreach ($resources as $key => $controller) {
    Route::resource("/$key", $controller);
    Route::post("/$key/query", [$controller, 'query'])->name("$key.query");
}

/*Route::resource('/categoria', CategoriaController::class);
Route::post('/categoria/query', [CategoriaController::class, 'query'])->name('categoria.query');

Route::resource('/item', ItemController::class);
Route::post('/item/query', [CategoriaController::class, 'query'])->name('item.query');

Route::resource('/unidad', UnidadController::class);
Route::post('/unidad/query', [UnidadController::class, 'query'])->name('unidad.query');

Route::resource('/almacen', AlmacenController::class);
Route::post('/almacen/query', [AlmacenController::class, 'query'])->name('almacen.query');

Route::resource('/sector', SectorController::class);
Route::post('/sector/query', [SectorController::class, 'query'])->name('sector.query');

Route::resource('/permissions', SectorController::class);
Route::post('/permissions/query', [SectorController::class, 'query'])->name('permissions.query');

Route::resource('/roles', SectorController::class);
Route::post('/roles/query', [SectorController::class, 'query'])->name('roles.query');*/

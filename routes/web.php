<?php

use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\UnidadController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoriaController;

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

Route::resource('/categoria', CategoriaController::class);
Route::post('/categoria/query', [CategoriaController::class, 'query'])->name('categoria.query');

Route::resource('/item', ItemController::class);
Route::post('/item/query', [CategoriaController::class, 'query'])->name('item.query');

Route::resource('/unidad', UnidadController::class);
Route::post('/unidad/query', [UnidadController::class, 'query'])->name('unidad.query');

Route::resource('/almacen', AlmacenController::class);
Route::post('/almacen/query', [AlmacenController::class, 'query'])->name('almacen.query');

Route::resource('/sector', SectorController::class);
Route::post('/sector/query', [SectorController::class, 'query'])->name('sector.query');

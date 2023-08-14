<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\ChartJsController;

use App\Exports\ArticulosExport;

/*
|--------------------------------------------------------------------------
| Web Routes
|------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome.index');

Auth::routes();





Route::group(['middleware' => ['Vendedor']], function () {

});

Route::group(['middleware' => ['Almacenero']], function () {

});

Route::group(['middleware' => ['Administrador']], function () {
   
    
        
        /**insumos */
        Route::get('/insumo', [App\Http\Controllers\InsumoController::class, 'index'])->name('insumo.index');

        Route::post('/insumo/registrar', [App\Http\Controllers\InsumoController::class, 'store'])->name('insumo.store');
        Route::put('/insumo/actualizar', [App\Http\Controllers\InsumoController::class, 'update'])->name('insumo.update');
        Route::put('/insumo/desactivar', [App\Http\Controllers\InsumoController::class, 'desactivar'])->name('insumo.desactivar');
//        Route::get('/insumo/listarPdf',  [App\Http\Controllers\ArticuloController::class, 'listarPdf'])->name('insumo_pdf');
        Route::get('/insumo/listarArticulo',  [App\Http\Controllers\InsumoController::class, 'listarInsumos'])->name('listarInsumo');
        Route::get('/insumo/listarInsumosInforme',  [App\Http\Controllers\InsumoController::class, 'listarInsumosInforme'])->name('listarInsumosInforme');
        Route::get('/insumo/exportarInsumos',  [App\Http\Controllers\InsumoController::class, 'exportarInsumos'])->name('exportarInsumo');
        Route::post('/insumo/importarInsumos',  [App\Http\Controllers\InsumoController::class, 'importarInsumos'])->name('importarInsumo');

        Route::put('/insumo/activar', [App\Http\Controllers\InsumoController::class, 'activar'])->name('insumo.activar');
        Route::put('/insumo', [App\Http\Controllers\InsumoController::class, 'destroy'])->name('insumo.destroy');
        /**insumo_fin */
        /**estudiantes */
        Route::get('/estudiante', [App\Http\Controllers\EstudianteController::class, 'index'])->name('estudiante.index');
        Route::post('/estudiante/registrar',[App\Http\Controllers\EstudianteController::class, 'store'])->name('estudiante.store');
        Route::put('/estudiante/actualizar', [App\Http\Controllers\EstudianteController::class, 'update'])->name('estudiante.update');
        Route::get('/estudiante/selectEstudiante', [App\Http\Controllers\EstudianteController::class, 'selectEstudiante'])->name('estudiante.selectEstudiante');
        Route::get('/estudiante/exportarEstudiantes',  [App\Http\Controllers\EstudianteController::class, 'exportarEstudiantes'])->name('exportarEstudiantes');
        Route::post('/estudiante/importarEstudiantes',  [App\Http\Controllers\EstudianteController::class, 'importarEstudiantes'])->name('importarEstudiantes');
        Route::put('/estudiante/desactivar', [App\Http\Controllers\EstudianteController::class, 'desactivar'])->name('estudiante.desactivar');
        Route::put('/estudiante/activar', [App\Http\Controllers\EstudianteController::class, 'activar'])->name('estudiante.activar');
        Route::put('/estudiante', [App\Http\Controllers\EstudianteController::class, 'destroy'])->name('estudiante.destroy');

        /**estudiantes_fin*/
        /**informe_medico */
        Route::get('/informe_medico', [App\Http\Controllers\InformeMedicoController::class, 'index'])->name('informe_medico.index');
        Route::post('/informe_medico/registrar',  [App\Http\Controllers\InformeMedicoController::class, 'store'])->name('informe_medico.store');
        Route::put('/informe_medico/desactivar',  [App\Http\Controllers\InformeMedicoController::class, 'desactivar'])->name('informe_medico.desactivar');
        Route::get('/informe_medico/obtenerCabecera',  [App\Http\Controllers\InformeMedicoController::class, 'obtenerCabecera'])->name('informe_medico.obtenerCabecera');
        Route::get('/informe_medico/obtenerDetalles',  [App\Http\Controllers\InformeMedicoController::class, 'obtenerDetalles'])->name('informe_medico.obtenerDetalles');
        Route::get('/informe_medico/pdf/{id}',  [App\Http\Controllers\InformeMedicoController::class, 'pdf'])->name('pdf');
        Route::get('/informe_medico/listapdf',  [App\Http\Controllers\InformeMedicoController::class, 'listarPdf'])->name('');


   
        Route::get('/rol/selectRol', [App\Http\Controllers\RolController::class, 'selectRol'] );
    
        Route::get('/user',  [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::post('/user/registrar', [App\Http\Controllers\UserController::class, 'store']);
        Route::put('/user/actualizar', [App\Http\Controllers\UserController::class, 'update'] );
        Route::put('/user/desactivar',[App\Http\Controllers\UserController::class, 'desactivar'] );
        Route::put('/user/activar', [App\Http\Controllers\UserController::class, 'activar'] );
    

    
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

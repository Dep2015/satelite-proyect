<?php

use App\Http\Controllers\AccionEstadoAtencionController;
use App\Http\Controllers\CampoObligatorioObraImpuestosController;
use App\Http\Controllers\EstadoAtencionController;
use App\Http\Controllers\ObraImpuestoController;
use App\Http\Controllers\TipodeAtencionController;
use App\Http\Controllers\TipoEstadoAtencionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout']);

  // APIS DE CONFIGURACIÓN 

  //apis tipo create
  Route::post('/add/tipoestadoatencion', [TipoEstadoAtencionController::class, 'addTipoEstadoAtencion']);

  //apis tipo edit
  Route::post('/edit/tipoestadoatencion', [TipoEstadoAtencionController::class, 'editTipoEstadoAtencion']);

  //apis tipo edit v2
  Route::post('/edit/tipoestadoatencion/{id_tipo}', [TipoEstadoAtencionController::class, 'editTipoEstadoAtencion2']);

  //apis tipo All
  Route::get('/all/tipoestadoatencion', [TipoEstadoAtencionController::class, 'allTipoEstadoAtencion']);

  //apis Tipo delete

  Route::post('/delete/tipoestadoatencion/{id_tipo}', [TipoEstadoAtencionController::class, 'deleteTipoEstadoAtencion']);

  //apis Tipo delete 2

  Route::post('/delete/tipoestadoatencion', [TipoEstadoAtencionController::class, 'deleteTipoEstadoAtencion2']);


  //apis campo obligatorio create
  Route::post('/add/campoobligatorioobraImpuestos', [CampoObligatorioObraImpuestosController::class, 'addCampoObligatorioObraImpuestos']);

  //apis campo obligatorio edit
  Route::post('/edit/campoobligatorioobraImpuestos', [CampoObligatorioObraImpuestosController::class, 'editCampoObligatorioObraImpuestos']);

  //apis campo obligatorio edit 2
  Route::post('/edit/campoobligatorioobraImpuestos/{id_campo}', [CampoObligatorioObraImpuestosController::class, 'editCampoObligatorioObraImpuestos2']);

  //apis campo obligatorio All
  Route::get('/all/campoobligatorioobraImpuestos', [CampoObligatorioObraImpuestosController::class, 'allCampoObligatorioObraImpuestos']);

  //apis campo obligatorio delete

  Route::post('/delete/campoobligatorioobraImpuestos/{id_campo}', [CampoObligatorioObraImpuestosController::class, 'deleteCampoObligatorioObraImpuestos']);

  //apis campo obligatorio delete 2

  Route::post('/delete/campoobligatorioobraImpuestos', [CampoObligatorioObraImpuestosController::class, 'deleteCampoObligatorioObraImpuestos2']);


  //apis Tipo de Atencion create
  Route::post('/add/tipodeatencion', [TipodeAtencionController::class, 'addTipodeAtencion']);

  //apis Tipo de Atencion edit
  Route::post('/edit/tipodeatencion', [TipodeAtencionController::class, 'editTipodeAtencion']);

  //apis Tipo de Atencion edit 2
  Route::post('/edit/tipodeatencion/{id_campo}', [TipodeAtencionController::class, 'editTipodeAtencion2']);

  //apis Tipo de Atencion All
  Route::get('/all/tipodeatencion', [TipodeAtencionController::class, 'allTipodeAtencion']);

  //apis Tipo de Atencion delete

  Route::post('/delete/tipodeatencion/{id_campo}', [TipodeAtencionController::class, 'deleteTipodeAtencion']);

  //apis Tipo de Atencion delete 2

  Route::post('/delete/tipodeatencion', [TipodeAtencionController::class, 'deleteTipodeAtencion2']);



  //apis accion estado atencion create
  Route::post('/add/accionestadoatencion', [AccionEstadoAtencionController::class, 'addAccionEstadoAtencion']);

  //apis accion estado atencion edit
  Route::post('/edit/accionestadoatencion', [AccionEstadoAtencionController::class, 'editAccionEstadoAtencion']);

  //apis accion estado atencion  edit 2
  Route::post('/edit/accionestadoatencion/{id_campo}', [AccionEstadoAtencionController::class, 'editAccionEstadoAtencion2']);

  //apis accion estado atencion  All
  Route::get('/all/accionestadoatencion', [AccionEstadoAtencionController::class, 'allAccionEstadoAtencion']);

  //apis accion estado atencion  delete

  Route::post('/delete/accionestadoatencion/{id_campo}', [AccionEstadoAtencionController::class, 'deleteAccionEstadoAtencion']);

  //apis accion estado atencion  delete 2

  Route::post('/delete/accionestadoatencion', [AccionEstadoAtencionController::class, 'deleteAccionEstadoAtencion2']);




  //apis estado atencion create
  Route::post('/add/estadodeatencion', [EstadoAtencionController::class, 'addEstadoAtencion']);

  //apis estado atencion edit
  Route::post('/edit/estadodeatencion', [EstadoAtencionController::class, 'editEstadoAtencion']);

  //apis estado atencion edit 2
  Route::post('/edit/estadodeatencion/{id_tipo}', [EstadoAtencionController::class, 'editEstadoAtencion2']);

  //apis estado atencion  All
  Route::get('/all/estadodeatencion', [EstadoAtencionController::class, 'allEstadoAtencion']);

  //apis accion estado atencion  delete

  Route::post('/delete/estadodeatencion/{id_campo}', [EstadoAtencionController::class, 'deleteEstadoAtencion']);

  //apis accion estado atencion  delete 2

  Route::post('/delete/estadodeatencion', [EstadoAtencionController::class, 'deleteEstadoAtencion2']);


  // Obra Impuesto

  Route::post('/add/obraporimpuesto', [ObraImpuestoController::class, 'addObraImpuesto']);

  Route::get('/all/obraporimpuesto', [ObraImpuestoController::class, 'allObraImpuesto']);


});
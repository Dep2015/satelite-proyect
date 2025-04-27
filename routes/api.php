<?php

use App\Http\Controllers\AccionEstadoAtencionController;
use App\Http\Controllers\CampoObligatorioObraImpuestosController;
use App\Http\Controllers\EstadoAtencionController;
use App\Http\Controllers\ObraImpuestoController;
use App\Http\Controllers\TipodeAtencionController;
use App\Http\Controllers\TipoEstadoAtencionController;
use App\Http\Controllers\AtencionEstadoController;
use App\Http\Controllers\PestaVistaController;
use App\Http\Controllers\ObraporImpuestoController;
use App\Http\Controllers\TipoGastoController;
use App\Http\Controllers\TipoFinancistaController;
use App\Http\Controllers\TipoContratistaController;
use App\Http\Controllers\EstadoRembolsoController;
use App\Http\Controllers\PagosOIController;
use App\Http\Controllers\InformacionContratistaController;
use App\Http\Controllers\InformacionFinancistaController;
use App\Http\Controllers\ActividadesEjecucionController;
use App\Http\Controllers\Archivos3Controller;
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
  Route::post('/add/atencionestados', [AtencionEstadoController::class, 'addAtencionEstados']);

  //apis estado atencion edit
  Route::post('/edit/estadodeatencions', [AtencionEstadoController::class, 'editAtencionEstados']);

  //apis estado atencion  All
  Route::get('/all/estadodeatencion', [AtencionEstadoController::class, 'allAtencionEstados']);

  //apis accion estado atencion  delete

  Route::post('/delete/estadodeatencion/{id_campo}', [AtencionEstadoController::class, 'deleteAtencionEstados']);

  //apis accion estado atencion  delete 2

  Route::post('/delete/estadodeatencion', [AtencionEstadoController::class, 'deleteEstadoAtencion2']);

  Route::post('/delete/estadodeatencions', [AtencionEstadoController::class, 'deleteAtencionEstados2']);





  // Obra Impuesto

  Route::post('/add/obraporimpuesto', [ObraporImpuestoController::class, 'addObraporImpuesto']);

  Route::post('/add/obraporimpuestov2', [ObraporImpuestoController::class, 'addObraporImpuestov2']);

  Route::get('/all/obraporimpuesto', [ObraporImpuestoController::class, 'allObraporImpuesto']);

  Route::get('/all/obraporimpuestoco', [ObraporImpuestoController::class, 'allObraporImpuestoCo']);

  Route::post('/edit/obraporimpuesto', [ObraporImpuestoController::class, 'editObraporImpuesto']);

  Route::post('/delete/obraporimpuesto', [ObraporImpuestoController::class, 'deleteObraporImpuesto']);

  Route::post('/edit/obraporimpuestoestado', [ObraporImpuestoController::class, 'editObraporImpuestoEstado']);





  // Vista Previa - ajustes

  Route::get('/all/pestavista', [PestaVistaController::class, 'allPestaVista']);
  Route::post('/add/pestavista', [PestaVistaController::class, 'addPestaVista']);
  Route::post('/edit/pestavista', [PestaVistaController::class, 'editPestaVista']);





  // Tipo de gasto


  Route::post('/add/tipogasto', [TipoGastoController::class, 'addTipoGasto']);

  Route::post('/edit/tipogasto', [TipoGastoController::class, 'editTipoGasto']);

  Route::post('/edit/tipogasto/{id_campo}', [TipoGastoController::class, 'editTipoGasto2']);

  Route::get('/all/tipogasto', [TipoGastoController::class, 'allTipoGasto']);

  Route::post('/delete/tipogasto/{id_campo}', [TipoGastoController::class, 'deleteTipoGasto']);

  Route::post('/delete/tipogasto', [TipoGastoController::class, 'deleteTipoGasto2']);





  // Tipo de financista


  Route::post('/add/tipofinancista', [TipoFinancistaController::class, 'addTipoFinancista']);

  Route::post('/edit/tipofinancista', [TipoFinancistaController::class, 'editTipoFinancista']);

  Route::post('/edit/tipofinancista/{id_campo}', [TipoFinancistaController::class, 'editTipoFinancista2']);

  Route::get('/all/tipofinancista', [TipoFinancistaController::class, 'allTipoFinancista']);

  Route::post('/delete/tipofinancista/{id_campo}', [TipoFinancistaController::class, 'deleteTipoFinancista']);

  Route::post('/delete/tipofinancista', [TipoFinancistaController::class, 'deleteTipoFinancista2']);





    // Tipo de Contratista


    Route::post('/add/tipocontratista', [TipoContratistaController::class, 'addTipoContratista']);

    Route::post('/edit/tipocontratista', [TipoContratistaController::class, 'editTipoContratista']);

    Route::post('/edit/tipocontratista/{id_campo}', [TipoContratistaController::class, 'editTipoContratista2']);

    Route::get('/all/tipocontratista', [TipoContratistaController::class, 'allTipoContratista']);

    Route::post('/delete/tipocontratista/{id_campo}', [TipoContratistaController::class, 'deleteTipoContratista']);

    Route::post('/delete/tipocontratista', [TipoContratistaController::class, 'deleteTipoContratista2']);




        // Estado Rembolso


    Route::post('/add/estadorembolso', [EstadoRembolsoController::class, 'addEstadoRembolso']);

    Route::post('/edit/estadorembolso', [EstadoRembolsoController::class, 'editEstadoRembolso']);

    Route::post('/edit/estadorembolso/{id_campo}', [EstadoRembolsoController::class, 'editEstadoRembolso2']);

    Route::get('/all/estadorembolso', [EstadoRembolsoController::class, 'allEstadoRembolso']);

    Route::post('/delete/estadorembolso/{id_campo}', [EstadoRembolsoController::class, 'deleteEstadoRembolso']);

    Route::post('/delete/estadorembolso', [EstadoRembolsoController::class, 'deleteEstadoRembolso2']);




      // Pago OI - Sprint 01

  Route::post('/add/pagosoi', [PagosOIController::class, 'addPagosOI']);

  Route::get('/all/pagosoi', [PagosOIController::class, 'allPagosOI']);

  Route::post('/edit/pagosoi', [PagosOIController::class, 'editPagosOI']);

  Route::post('/delete/pagosoi', [PagosOIController::class, 'deletePagosOI']);


        // Pago OI - Sprint 01 - corregido

  Route::post('/add/pagosois', [PagosOIController::class, 'addPagosOI']);

  Route::get('/all/pagosois', [PagosOIController::class, 'allPagosOI']);

  Route::post('/edit/pagosois', [PagosOIController::class, 'editPagosOI']);

  Route::post('/delete/pagosois', [PagosOIController::class, 'deletePagosOI']);

  Route::post('/edit/pagosoiestado', [PagosOIController::class, 'editPagosOIEstado']);







        // Informacion Financista

  Route::post('/add/informacionfinancista', [InformacionFinancistaController::class, 'addInformacionFinancista']);

  Route::get('/all/informacionfinancista', [InformacionFinancistaController::class, 'allInformacionFinancista']);

  Route::post('/edit/informacionfinancista', [InformacionFinancistaController::class, 'editInformacionFinancista']);

  Route::post('/delete/informacionfinancista', [InformacionFinancistaController::class, 'deleteInformacionFinancista']);





          // Informacion Contratista

  Route::post('/add/informacioncontratista', [InformacionContratistaController::class, 'addInformacionContratista']);

  Route::get('/all/informacioncontratista', [InformacionContratistaController::class, 'allInformacionContratista']);

  Route::post('/edit/informacioncontratista', [InformacionContratistaController::class, 'editInformacionContratista']);

  Route::post('/delete/informacioncontratista', [InformacionContratistaController::class, 'deleteInformacionContratista']);





  // Actividades Etapas Ejecución


  Route::post('/add/etapaejecucion', [ActividadesEjecucionController::class, 'addActividadesEjecucion']);

  Route::get('/all/etapaejecucion', [ActividadesEjecucionController::class, 'allActividadesEjecucion']);

  Route::get('/all/etapaejecucionporetapa', [ActividadesEjecucionController::class, 'allActividadesEjecucionporEtpa']);

  Route::post('/edit/etapaejecucion', [ActividadesEjecucionController::class, 'editActividadesEjecucion']);

  Route::post('/edit/estadoetapaejecucion', [ActividadesEjecucionController::class, 'editActividadesEjecucionTipo']);

  Route::post('/delete/etapaejecucion', [ActividadesEjecucionController::class, 'deleteActividadesEjecucion']);

  Route::get('/all/actividadesejecucionnombre', [ActividadesEjecucionController::class, 'allActividadesEjecucionNombre']);




 // Subirt archivos S3



Route::post('/archivos/subir', [Archivos3Controller::class, 'subirArchivo']);

Route::get('/archivos/all', [Archivos3Controller::class, 'listarArchvio2']);

Route::delete('/archivosdelete/{id}', [Archivos3Controller::class, 'eliminar']);

});

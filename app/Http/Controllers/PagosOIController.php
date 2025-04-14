<?php

namespace App\Http\Controllers;

use App\Models\PagosOI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagosOIController extends Controller
{
    public function addPagosOI(Request $request)
    {
        $validated = Validator::make($request->all(), [

            'id_tipo_gasto' => 'required|exists:tipo_gastos,id',
            'id_obra_impuesto' => 'required|integer',
            'id_estado_rembolso' => 'required|exists:estado_rembolsos,id',
            'monto_pagado' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'concepto'=>'required|string|max:255',
            'beneficiario' => 'required|nullable|array',
            'beneficiario.*.id' => 'required|integer',
            'beneficiario.*.nombre' => 'required|string|max:255',
            'grupo_interes' => 'required|nullable|array',
            'grupo_interes.*.id' => 'required|integer',
            'grupo_interes.*.nombre' => 'required|string|max:255',
            'responsables' => 'required|nullable|array',
            'responsables.*.id' => 'required|integer',
            'responsables.*.nombre' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 403);
        }

        try {

            $pagos = new PagosOI();
            $pagos->id_tipo_gasto = $request->id_tipo_gasto;
            $pagos->id_obra_impuesto = $request->id_obra_impuesto;
            $pagos->id_estado_rembolso = $request->id_estado_rembolso;
            $pagos->monto_pagado = $request->monto_pagado;
            $pagos->fecha = $request->fecha;
            $pagos->concepto = $request->concepto;
            $pagos->beneficiario = $request->beneficiario;
            $pagos->grupo_interes = $request->unidades_gestion;
            $pagos->responsables = $request->responsables;
            $pagos->id_empresa = $request->id_empresa;
            $pagos->save();

            return response()->json([
                'message' => 'Pago ingresado con éxito',
                'obra_id' => $pagos->id
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }


    public function editPagosOI(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
            'id_tipo_gasto' => 'required|exists:tipo_gastos,id',
            'id_estado_rembolso' => 'required|exists:estado_rembolsos,id',
            'monto_pagado' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'concepto'=>'string|max:255',
            'beneficiario' => 'required|nullable|array',
            'beneficiario.*.id' => 'required|integer',
            'beneficiario.*.nombre' => 'required|string|max:255',
            'grupo_interes' => 'required|nullable|array',
            'grupo_interes.*.id' => 'required|integer',
            'grupo_interes.*.nombre' => 'required|string|max:255',
            'responsables' => 'required|nullable|array',
            'responsables.*.id' => 'required|integer',
            'responsables.*.nombre' => 'required|string|max:255',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoPagosOI_data = PagosOI::find($request->id);


           $updatePagosOI = $tipoPagosOI_data->update([
                'id_tipo_gasto' => $request->id_tipo_gasto,
                'id_estado_rembolso' => $request->id_estado_rembolso,
                'monto_pagado' => $request->monto_pagado,
                'fecha' => $request->fecha,
                'concepto' => $request->concepto,
                'beneficiario' => json_encode($request->beneficiario),
                'grupo_interes' => json_encode($request->grupo_interes),
                'responsables' => json_encode($request->responsables),
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'data' => $updatePagosOI,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }



    public function editPagosOIEstado(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
            'id_estado_rembolso' => 'required|exists:estado_rembolsos,id',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoPagosOI_data = PagosOI::find($request->id);


           $updatePagosOI = $tipoPagosOI_data->update([

                'id_estado_rembolso' => $request->id_estado_rembolso,

            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'data' => $updatePagosOI,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function deletePagosOI(Request $request)
{
    $validated = Validator::make($request->all(), [
        'id' => 'required|integer',
    ]);

    if ($validated->fails()) {
        return response()->json([
            'error' => 'Error de validación',
            'messages' => $validated->errors()
        ], 403);
    }

    try {
        $pagosOI = PagosOI::findOrFail($request->id);
        $pagosOI->delete();

        return response()->json([
            'message' => 'Pago eliminado con éxito'
        ], 200);

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'error' => 'El ID proporcionado no existe en la tabla'
        ], 404);

    } catch (\Exception $exceptiondelete) {
        return response()->json([
            'error' => 'Error al eliminar el pago',
            'message' => $exceptiondelete->getMessage()
        ], 500);
    }
}


public function allPagosOI(Request $request)
{
    // Validar la entrada
    $validated = Validator::make($request->all(), [
        'id_empresa' => 'required|integer',
        'id_obra_impuesto'=> 'required|integer',
    ]);

    if ($validated->fails()) {
        return response()->json([
            'error' => 'Error de validación',
            'messages' => $validated->errors()
        ], 403);
    }

    try {
        // Obtener los pagos de la empresa especificada con relaciones si las hay
        $itemsPagosOI = PagosOI::where('id_empresa', $request->id_empresa)->where('id_obra_impuesto', $request->id_obra_impuesto)->with(['tipoGasto:id,name', 'estadoReembolso:id,name'])->get();

        return response()->json([
            'success' => true,
            'data' => $itemsPagosOI
        ], 200);

    } catch (\Exception $exceptionall) {
        return response()->json([
            'error' => 'Error al obtener los pagos',
            'message' => $exceptionall->getMessage()
        ], 500);
    }
}



}

<?php

namespace App\Http\Controllers;

use App\Models\ObraporImpuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObraporImpuestoController extends Controller
{
    public function addObraporImpuesto(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'tipo_id' => 'required|exists:tipo_estado_atencions,id',
            'estado_id' => 'required|exists:atencion_estados,id',
            'costo_proyecto' => 'required|numeric|min:0',
            'fecha_conclusion' => 'required|date',
            'fecha_reembolso' => 'required|date',
            'responsable' => 'required|nullable|array',
            'responsable.*.id' => 'required|integer',
            'responsable.*.nombre' => 'required|string|max:255',
            'unidades_gestion' => 'required|nullable|array',
            'unidades_gestion.*.id' => 'required|integer',
            'unidades_gestion.*.nombre' => 'required|string|max:255',
            'centros_operacion' => 'required|nullable|array',
            'centros_operacion.*.id' => 'required|integer',
            'centros_operacion.*.nombre' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 403);
        }

        try {

            $obra = new ObraporImpuesto();
            $obra->nombre = $request->nombre;
            $obra->tipo_id = $request->tipo_id;
            $obra->estado_id = $request->estado_id;
            $obra->costo_proyecto = $request->costo_proyecto;
            $obra->fecha_conclusion = $request->fecha_conclusion;
            $obra->fecha_reembolso = $request->fecha_reembolso;
            $obra->responsable = $request->responsable;
            $obra->unidades_gestion = $request->unidades_gestion;
            $obra->centros_operacion = $request->centros_operacion;
            $obra->id_empresa = $request->id_empresa;
            $obra->save();

            return response()->json([
                'message' => 'Obra creada con éxito',
                'obra_id' => $obra->id
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }



    public function allObraporImpuesto(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsObraporImpuesto = ObraporImpuesto::where('id_empresa', $request->id_empresa)->with(['estado:id,name', 'tipo:id,name'])->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsObraporImpuesto,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),
                ],403);
           }

    }
}

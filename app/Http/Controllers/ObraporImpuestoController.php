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


    public function editObraporImpuesto(Request $request)
{
    // Validar los datos recibidos
    $validated = Validator::make($request->all(), [
        'id' => 'required|exists:obrapor_impuestos,id', // Validar que la obra exista
        'nombre' => 'required|string|max:255',
        'tipo_id' => 'required|exists:tipo_estado_atencions,id',
        'estado_id' => 'required|exists:atencion_estados,id',
        'costo_proyecto' => 'required|numeric|min:0',
        'fecha_conclusion' => 'required|date',
        'fecha_reembolso' => 'required|date',

        // Validación de responsable (array de objetos)
        'responsable' => 'nullable|array',
        'responsable.*.id' => 'required|integer',
        'responsable.*.nombre' => 'required|string|max:255',

        // Validación de unidades de gestión (array de objetos)
        'unidades_gestion' => 'nullable|array',
        'unidades_gestion.*.id' => 'required|integer',
        'unidades_gestion.*.nombre' => 'required|string|max:255',

        // Validación de centros de operación (array de objetos)
        'centros_operacion' => 'nullable|array',
        'centros_operacion.*.id' => 'required|integer',
        'centros_operacion.*.nombre' => 'required|string|max:255',

    ]);

    // Si la validación falla, devolver error
    if ($validated->fails()) {
        return response()->json([
            'error' => 'Error de validación',
            'messages' => $validated->errors()
        ], 403);
    }

    try {
        // Buscar la obra en la base de datos
        $obra = ObraporImpuesto::findOrFail($request->id);

        // Actualizar los datos
        $obra->update([
            'nombre' => $request->nombre,
            'tipo_id' => $request->tipo_id,
            'estado_id' => $request->estado_id,
            'costo_proyecto' => $request->costo_proyecto,
            'fecha_conclusion' => $request->fecha_conclusion,
            'fecha_reembolso' => $request->fecha_reembolso,
            'responsable' => json_encode($request->responsable), // Guardar como JSON
            'unidades_gestion' => json_encode($request->unidades_gestion),
            'centros_operacion' => json_encode($request->centros_operacion),
        ]);

        return response()->json([
            'message' => 'Obra actualizada con éxito',
            'obra' => $obra
        ], 200);

    } catch (\Exception $exception) {
        return response()->json([
            'error' => 'Error al actualizar la obra',
            'message' => $exception->getMessage()
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


    public function deleteObraporImpuesto(Request $request)
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
        $obra = ObraporImpuesto::findOrFail($request->id);
        $obra->delete();

        return response()->json([
            'message' => 'Obra eliminada con éxito'
        ], 200);

    } catch (\Exception $exceptiondelete) {
        return response()->json([
            'error' => 'Error al eliminar la obra',
            'message' => $exceptiondelete->getMessage()
        ], 500);
    }
}

}

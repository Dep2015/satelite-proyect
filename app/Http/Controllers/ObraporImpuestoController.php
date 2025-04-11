<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\ObraporImpuesto;
use App\Models\ActividadesEjecucion;
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

    public function addObraporImpuestov2(Request $request)
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

        // Actividades predefinidas
        $actividadesBase = [
            [1, 'Aprobar la Capacidad Presupuestal', 1, 1],
            [2, 'Aprobar la Ejecución Conjunta de Proyectos', 1, 3],
            [3, 'Evaluar la Propuesta de Proyectos de Sector Privado', 1, 3],
            [4, 'Aprobar la Lista de Proyectos Priorizados por Entidad Pública', 1, 1],
            [1, 'Designar al Comité Especial', 2, 3],
            [2, 'Otorgar la Certificación Presupuestaría y/o compromiso', 2, 3],
            [3, 'Aprobar las bases para el proceso de selección', 2, 3],
            [1, 'Realizar el Proceso de Selección', 3, 1],
            [1, 'Realizar la suscripción de Convenio', 4, 1],
            [2, 'Realizar el suscripción de contrato de la Supervisión del Proyecto', 4, 1],
            [3, 'Realizar modificación de Estudios', 4, 1],
            [4, 'Aprobar el Estudio definitivo expediente de operación y/o mantenimiento', 4, 1],
            [5, 'Aprobar la Sustitución del Ejecutor de Proyecto', 4, 1],
            [6, 'Aprobar la ampliación de plazos', 4, 1],
            [7, 'Realizar la culminación y recepción del proyecto', 4, 1],
            [8, 'Aprobar la liquidación del proyecto', 4, 1],
            [9, 'Emitir conformidad de Mantenimiento u Operación', 4, 1],
            [1, 'Emitir el CIPRL o CIPGN',5, 1],
            [2, 'Emitir el CIPRL o CIPGN por Avance de Obra', 5, 1],
        ];

        foreach ($actividadesBase as [$secuencia, $nombre, $atencionEstado, $tipoEstado]) {
            ActividadesEjecucion::create([
                'secuencia_id' => $secuencia,
                'name' => $nombre,
                'fecha' => Carbon::now()->toDateString(),
                'comentarios' => '',
                'responsables' => [],
                'id_empresa' => $obra->id_empresa,
                'id_obra_impuesto' => $obra->id,
                'atencion_estado_id' => $atencionEstado,
                'tipo_estado_ejecucion_id' => $tipoEstado,
            ]);
        }

        return response()->json([
            'message' => 'Obra y actividades creadas con éxito',
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

        ActividadesEjecucion::where('id_obra_impuesto', $request->id)->delete();

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

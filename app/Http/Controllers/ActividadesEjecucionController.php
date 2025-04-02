<?php

namespace App\Http\Controllers;
use App\Models\ActividadesEjecucion;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ActividadesEjecucionController extends Controller
{
    public function addActividadesEjecucion(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'secuencia_id'=>'required|integer',
            'name' => 'required|string|max:255',
            'fecha' => 'required|date',
            'comentarios' => 'required|string',
            'atencion_estado_id' => 'required|exists:atencion_estados,id',
            'tipo_estado_ejecucion_id'=>'required|exists:estado_etapa_ejecucions,id',
            'responsable' => 'required|nullable|array',
            'responsable.*.id' => 'required|integer',
            'responsable.*.nombre' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 403);
        }

        try{

            $EstadoAtencion = new ActividadesEjecucion();
            $EstadoAtencion->secuencia_id = $request->secuencia_id;
            $EstadoAtencion->name = $request->name;
            $EstadoAtencion->fecha = $request->fecha;
            $EstadoAtencion->comentarios = $request->comentarios;
            $EstadoAtencion->atencion_estado_id = $request->atencion_estado_id;
            $EstadoAtencion->tipo_estado_ejecucion_id = $request->tipo_estado_ejecucion_id;
            $EstadoAtencion->responsable = $request->responsable;
            $EstadoAtencion->id_empresa = $request->id_empresa;
            $EstadoAtencion->save();

            return response()->json(
                [
                    'message'=> 'Estado de actividades added Succeccfully',
                    'tipo_id' => $EstadoAtencion->id
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }
    }


    public function allActividadesEjecucion(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsEstadoAtencion = ActividadesEjecucion::where('id_empresa', $request->id_empresa)->with(['atencion_estado:id,name'])->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsEstadoAtencion,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),
                ],403);
           }

    }

    public function allActividadesEjecucionporEtpa(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
             'tipo_estado_ejecucion_id' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsEstadoAtencion = ActividadesEjecucion::where('id_empresa', $request->id_empresa)->where('tipo_estado_ejecucion_id', $request->tipo_estado_ejecucion_id)->with(['atencion_estado:id,name',
            'tipo_estado_etapa_ejecucion:id,name'])->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsEstadoAtencion,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),
                ],403);
           }

    }

    public function editActividadesEjecucion(Request $request)
    {
        // Validar los datos recibidos
        $validated = Validator::make($request->all(), [
            'secuencia_id'=>'required|integer',
            'name' => 'required|string|max:255',
            'fecha' => 'required|date',
            'comentarios' => 'required|string',
            'atencion_estado_id' => 'required|exists:atencion_estados,id',
            'tipo_estado_ejecucion_id'=>'required|exists:estado_etapa_ejecucions,id',

            // Validación de responsable (array de objetos)
            'responsable' => 'nullable|array',
            'responsable.*.id' => 'required|integer',
            'responsable.*.nombre' => 'required|string|max:255',

            'id_empresa' => 'required|integer',
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
            $actividad = ActividadesEjecucion::findOrFail($request->id);

            // Actualizar los datos
            $actividad->update([
                'secuencia_id' => $request->secuencia_id,
                'name' => $request->name,
                'fecha' => $request->fecha,
                'comentarios' => $request->comentarios,
                'atencion_estado_id' => $request->atencion_estado_id,
                'tipo_estado_ejecucion_id' => $request->tipo_estado_ejecucion_id,
                'responsable' => json_encode($request->responsable), // Guardar como JSON
            ]);

            return response()->json([
                'message' => 'Actividad actualizada con éxito',
                'obra' => $actividad
            ], 200);

        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Error al actualizar la obra',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function deleteActividadesEjecucion(Request $request)
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
            $actividads = ActividadesEjecucion::findOrFail($request->id);
            $actividads->delete();

            return response()->json([
                'message' => 'Actividad eliminada con éxito'
            ], 200);

        } catch (\Exception $exceptiondelete) {
            return response()->json([
                'error' => 'Error al eliminar la Actividad',
                'message' => $exceptiondelete->getMessage()
            ], 500);
        }
    }
}

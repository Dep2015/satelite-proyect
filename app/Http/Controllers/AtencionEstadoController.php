<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtencionEstados;
use App\Models\ActividadEstadoAtencion;
use Illuminate\Support\Facades\Validator;

class AtencionEstadoController extends Controller
{
    public function addAtencionEstados(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color'  => 'required|string|max:255',
            'irechazo'  => 'required|string|max:255',
            'iavance'  => 'required|string|max:255',
            'accion_id' => 'required|exists:accion_estado_atencions,id',
            'tipo_id' => 'required|exists:tipode_atencions,id',
            'descripcion' => 'nullable|string',
            'id_empresa' => 'required|integer',
            'actividades' => 'nullable|array',
            'actividades.*.secuencia' => 'required|integer',
            'actividades.*.nombre' => 'required|string|max:255',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 403);
        }

        try{

            $EstadoAtencion = new AtencionEstados();
            $EstadoAtencion->name = $request->name;
            $EstadoAtencion->color = $request->color;
            $EstadoAtencion->irechazo = $request->irechazo;
            $EstadoAtencion->iavance = $request->iavance;
            $EstadoAtencion->descripcion = $request->descripcion;
            $EstadoAtencion->id_empresa = $request->id_empresa;
            $EstadoAtencion->accion_id = $request->accion_id;
            $EstadoAtencion->tipo_id = $request->tipo_id;
            $EstadoAtencion->actividades  = $request->actividades;
            $EstadoAtencion->save();

            return response()->json(
                [
                    'message'=> 'Estado de Atencion added Succeccfully',
                    'tipo_id' => $EstadoAtencion->id
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }
    }

    public function addAtencionEstadosv1(Request $request)
{
    $validated = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'color'  => 'required|string|max:255',
        'irechazo'  => 'required|string|max:255',
        'iavance'  => 'required|string|max:255',
        'accion_id' => 'required|exists:accion_estado_atencions,id',
        'tipo_id' => 'required|exists:tipode_atencions,id',
        'descripcion' => 'nullable|string',
        'id_empresa' => 'required|integer',
        'actividades' => 'nullable|array',
        'actividades.*.secuencia' => 'required|integer',
        'actividades.*.nombre' => 'required|string|max:255',
    ]);

    if ($validated->fails()) {
        return response()->json($validated->errors(), 403);
    }

    try {
        $estado = new AtencionEstados();
        $estado->name = $request->name;
        $estado->color = $request->color;
        $estado->irechazo = $request->irechazo;
        $estado->iavance = $request->iavance;
        $estado->descripcion = $request->descripcion;
        $estado->id_empresa = $request->id_empresa;
        $estado->accion_id = $request->accion_id;
        $estado->tipo_id = $request->tipo_id;
        $estado->actividades = $request->actividades; // Se guarda como JSON, si quieres
        $estado->save();

        // Guardar actividades relacionadas en la tabla separada
        if (!empty($request->actividades)) {
            foreach ($request->actividades as $actividad) {
                ActividadEstadoAtencion::create([
                    'secuencia' => $actividad['secuencia'],
                    'nombre' => $actividad['nombre'],
                    'id_estado_atencion' => $estado->id
                ]);
            }
        }

        return response()->json([
            'message' => 'Estado de Atención y actividades añadidas correctamente',
            'estado_id' => $estado->id
        ], 200);

    } catch (\Exception $exception) {
        return response()->json([
            'error' => 'Error al crear el Estado de Atención',
            'message' => $exception->getMessage()
        ], 500);
    }
}

    public function editAtencionEstados(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'color'  => 'required|string|max:255',
            'irechazo'  => 'required|string|max:255',
            'iavance'  => 'required|string|max:255',
            'accion_id' => 'required|exists:accion_estado_atencions,id',
            'tipo_id' => 'required|exists:tipode_atencions,id',
            'descripcion' => 'nullable|string',
            'id_empresa' => 'required|integer',
            'actividades' => 'nullable|array',
            'actividades.*.secuencia' => 'required|integer',
            'actividades.*.nombre' => 'required|string|max:255',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $EstadoAtencion_data = AtencionEstados::find($request->id);


           $updateEstadoAtencion = $EstadoAtencion_data->update([
                 'name'=> $request->name,
                 'color' => $request->color,
                 'irechazo' => $request->irechazo,
                 'iavance' => $request->iavance,
                 'descripcion' => $request->descripcion,
                 'id_empresa' => $request->id_empresa,
                 'accion_id' => $request->accion_id,
                 'tipo_id' => $request->tipo_id,
                 'actividades'  => $request->actividades,
            ]);

            return response()->json(
                [
                    'message'=> 'Estado updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateEstadoAtencion,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function editAtencionEstadosv1(Request $request)
{
    $validated = Validator::make($request->all(), [
        'id' => 'required|integer|exists:atencion_estados,id',
        'name' => 'required|string|max:255',
        'color'  => 'required|string|max:255',
        'irechazo'  => 'required|string|max:255',
        'iavance'  => 'required|string|max:255',
        'accion_id' => 'required|exists:accion_estado_atencions,id',
        'tipo_id' => 'required|exists:tipode_atencions,id',
        'descripcion' => 'nullable|string',
        'id_empresa' => 'required|integer',
        'actividades' => 'nullable|array',
        'actividades.*.secuencia' => 'required|integer',
        'actividades.*.nombre' => 'required|string|max:255',
    ]);

    if ($validated->fails()) {
        return response()->json([
            'error' => 'Error de validación',
            'messages' => $validated->errors()
        ], 403);
    }

    try {
        $estado = AtencionEstados::findOrFail($request->id);

        $estado->update([
            'name' => $request->name,
            'color' => $request->color,
            'irechazo' => $request->irechazo,
            'iavance' => $request->iavance,
            'descripcion' => $request->descripcion,
            'id_empresa' => $request->id_empresa,
            'accion_id' => $request->accion_id,
            'tipo_id' => $request->tipo_id,
            'actividades' => $request->actividades,
        ]);

        // Eliminar todas las actividades anteriores
        ActividadEstadoAtencion::where('id_estado_atencion', $estado->id)->delete();

        // Volver a registrar actividades si existen
        if (!empty($request->actividades)) {
            foreach ($request->actividades as $actividad) {
                ActividadEstadoAtencion::create([
                    'secuencia' => $actividad['secuencia'],
                    'nombre' => $actividad['nombre'],
                    'id_estado_atencion' => $estado->id
                ]);
            }
        }

        return response()->json([
            'message' => 'Estado de Atención actualizado con éxito',
            'estado_id' => $estado->id
        ], 200);

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'error' => 'El Estado de Atención no existe'
        ], 404);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al actualizar el Estado de Atención',
            'message' => $e->getMessage()
        ], 500);
    }
}


    public function allAtencionEstados(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsEstadoAtencion = AtencionEstados::where('id_empresa', $request->id_empresa)->with(['accionestado:id,name', 'acciontipoatencion:id,name'])->get();

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


    public function deleteAtencionEstados(Request $request, $id_tipo){
        try {
            $estado = AtencionEstados::findOrFail($id_tipo);
            $estado->delete();

            return response()->json([
                'message' => 'Estado eliminado con éxito'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'El estado con el ID proporcionado no existe'
            ], 404);

        } catch (\Exception $exceptiondelete) {
            return response()->json([
                'error' => 'Error al eliminar el estado',
                'message' => $exceptiondelete->getMessage()
            ], 500);
        }
    }


    public function deleteAtencionEstados2(Request $request){
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
            $estado = AtencionEstados::findOrFail($request->id);
            $estado->delete();

            return response()->json([
                'message' => 'Estado eliminado con éxito'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'El estado con el ID proporcionado no existe'
            ], 404);

        } catch (\Exception $exceptiondelete) {
            return response()->json([
                'error' => 'Error al eliminar el estado',
                'message' => $exceptiondelete->getMessage()
            ], 500);
        }
    }
}

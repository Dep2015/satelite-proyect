<?php

namespace App\Http\Controllers;

use App\Models\EstadoAtencion;
use App\Models\ActividadesEstadoAtencion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EstadoAtencionController extends Controller
{

    public function addEstadoAtencion(Request $request)
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
            'procesos' => 'nullable|array',
            'procesos.*.secuencia' => 'required|integer',
            'procesos.*.nombre' => 'required|string|max:255',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 403);
        }

        DB::beginTransaction(); // Inicia la transacción

        try {
            // Guardar Estado de Atención
            $EstadoAtencion = new EstadoAtencion();
            $EstadoAtencion->name = $request->name;
            $EstadoAtencion->color = $request->color;
            $EstadoAtencion->irechazo = $request->irechazo;
            $EstadoAtencion->iavance = $request->iavance;
            $EstadoAtencion->accion_id = $request->accion_id;
            $EstadoAtencion->tipo_id = $request->tipo_id;
            $EstadoAtencion->descripcion = $request->descripcion;
            $EstadoAtencion->id_empresa = $request->id_empresa;
            $EstadoAtencion->save();

            // Guardar Procesos si existen
            if ($request->has('procesos')) {
                foreach ($request->procesos as $proceso) {
                    ActividadesEstadoAtencion::create([
                        'estado_atencion_id' => $EstadoAtencion->id,
                        'secuencia' => $proceso['secuencia'],
                        'nombre' => $proceso['nombre'],
                        'descripcion' => $proceso['descripcion'] ?? null,
                    ]);
                }
            }

            DB::commit(); // Confirma la transacción

            return response()->json([
                'message' => 'Estado y procesos agregados exitosamente',
                'estado_id' => $EstadoAtencion->id
            ], 200);

        } catch (\Exception $exception) {
            DB::rollback(); // Revierte la transacción en caso de error
            return response()->json([
                'error' => $exception->getMessage(),
            ], 403);
        }
    }

    public function addEstadoAtencionv2(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color'  => 'required|string|max:255',
            'irechazo'  => 'required|string|max:255',
            'iavance'  => 'required|string|max:255',
            'accion_id' => 'required|exists:accion_estado_atencions,id',
            'tipo_id' => 'required|exists:tipode_atencions,id',
            'descripcion' => 'string',
            'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $EstadoAtencion = new EstadoAtencion();
            $EstadoAtencion->name = $request->name;
            $EstadoAtencion->color = $request->color;
            $EstadoAtencion->irechazo = $request->irechazo;
            $EstadoAtencion->iavance = $request->iavance;
            $EstadoAtencion->accion_id = $request->accion_id;
            $EstadoAtencion->tipo_id = $request->tipo_id;
            $EstadoAtencion->descripcion = $request->descripcion;
            $EstadoAtencion->id_empresa = $request->id_empresa;
            $EstadoAtencion->save();

            return response()->json(
                [
                    'message'=> 'Tipo added Succeccfully',
                    'tipo_id' => $EstadoAtencion->id
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }
    }


    public function editEstadoAtencion(Request $request){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color'  => 'required|string|max:255',
            'irechazo'  => 'required|string|max:255',
            'iavance'  => 'required|string|max:255',
            'accion_id' => 'required|exists:accion_estado_atencions,id',
            'tipo_id' => 'required|exists:tipode_atencions,id',
            'descripcion' => 'string',
            'id' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $EstadoAtencion_data = EstadoAtencion::find($request->id);


           $updateEstadoAtencion = $EstadoAtencion_data->update([
                'name'=> $request->name,
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


    public function editEstadoAtencion2(Request $request,$id_tipo){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color'  => 'required|string|max:255',
            'irechazo'  => 'required|string|max:255',
            'iavance'  => 'required|string|max:255',
            'accion_id' => 'required|exists:accion_estado_atencions,id',
            'tipo_id' => 'required|exists:tipode_atencions,id',
            'descripcion' => 'string',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $EstadoAtencion_data = EstadoAtencion::find($id_tipo);


           $updateEstadoAtencion = $EstadoAtencion_data->update([
                'name'=> $request->name,
                'color'=> $request->color,
                'irechazo'=> $request->irechazo,
                'iavance'=> $request->iavance,
                'accion_id'=> $request->accion_id,
                'tipo_id'=> $request->tipo_id,
                'descripcion'=> $request->descripcion,

            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateEstadoAtencion,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function allEstadoAtencion(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsEstadoAtencion = EstadoAtencion::where('id_empresa', $request->id_empresa)->with(['accionestado:id,name', 'acciontipoatencion:id,name'])->get();

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


    public function deleteEstadoAtencion(Request $request, $id_tipo){

        try{
            $EstadoAtencion = EstadoAtencion::find($id_tipo);
            $EstadoAtencion->delete();
            return response()->json(
                [
                    'message'=> 'Estado delete Succeccfully'
                ],200 );


        } catch(\Exception $exceptiondelete){
            return response()->json([
                'error'=> $exceptiondelete->getMessage(),
                ],403);
        }
    }


    public function deleteEstadoAtencion2(Request $request){

        $validated = Validator::make($request->all(), [
            'id_empresa' => 'required|integer',
           ]);

          if($validated->fails()){
              return response()->json($validated->errors(),403);
          }

        try{
            $EstadoAtencion = EstadoAtencion::find($request->id);
            $EstadoAtencion->delete();
            return response()->json(
                [
                    'message'=> 'Estado delete Succeccfully'
                ],200 );


        } catch(\Exception $exceptiondelete){
            return response()->json([
                'error'=> $exceptiondelete->getMessage(),
                ],403);
        }
    }


}

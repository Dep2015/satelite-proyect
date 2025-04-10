<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtencionEstados;
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

        try{
            $EstadoAtencion = AtencionEstados::find($id_tipo);
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


    public function deleteAtencionEstados2(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
           ]);

          if($validated->fails()){
              return response()->json($validated->errors(),403);
          }

        try{
            $EstadoAtencion = AtencionEstados::find($request->id);
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

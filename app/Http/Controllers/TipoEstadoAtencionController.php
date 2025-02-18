<?php

namespace App\Http\Controllers;

use App\Models\TipoEstadoAtencion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TipoEstadoAtencionController extends Controller
{
    public function addTipoEstadoAtencion(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoEstadoAtencion = new TipoEstadoAtencion();
            $tipoEstadoAtencion->name = $request->name;
            $tipoEstadoAtencion->id_empresa = $request->id_empresa;
            $tipoEstadoAtencion->save();

            return response()->json(
                [
                    'message'=> 'Tipo added Succeccfully',
                    'tipo_id' => $tipoEstadoAtencion->id
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),  
                ],403);

           }
    }

    public function editTipoEstadoAtencion(Request $request){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id' => 'required|integer',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoEstadoAtencion_data = TipoEstadoAtencion::find($request->id);


           $updateTipoEstadoAtencion = $tipoEstadoAtencion_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateTipoEstadoAtencion,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),  
                ],403);

           }

    }


    public function editTipoEstadoAtencion2(Request $request,$id_tipo){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoEstadoAtencion_data = TipoEstadoAtencion::find($id_tipo);


           $updateTipoEstadoAtencion = $tipoEstadoAtencion_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateTipoEstadoAtencion,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),  
                ],403);

           }

    }


    public function allTipoEstadoAtencion(Request $request){
    
        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsTipoEstadoAtencion = TipoEstadoAtencion::where('id_empresa', $request->id_empresa)->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsTipoEstadoAtencion,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),  
                ],403);
           }
    
    }

    public function deleteTipoEstadoAtencion(Request $request, $id_tipo){

        try{
            $tipoEstadoAtencion = TipoEstadoAtencion::find($id_tipo);
            $tipoEstadoAtencion->delete();
            return response()->json(
                [
                    'message'=> 'Tipo delete Succeccfully'
                ],200 );


        } catch(\Exception $exceptiondelete){
            return response()->json([
                'error'=> $exceptiondelete->getMessage(),  
                ],403);
        }
    }


    public function deleteTipoEstadoAtencion2(Request $request){

        $validated = Validator::make($request->all(), [
            'id_empresa' => 'required|integer',
           ]);
          
          if($validated->fails()){
              return response()->json($validated->errors(),403);
          }

        try{
            $tipoEstadoAtencion = TipoEstadoAtencion::find($request->id);
            $tipoEstadoAtencion->delete();
            return response()->json(
                [
                    'message'=> 'Tipo delete Succeccfully'
                ],200 );


        } catch(\Exception $exceptiondelete){
            return response()->json([
                'error'=> $exceptiondelete->getMessage(),  
                ],403);
        }
    }


}

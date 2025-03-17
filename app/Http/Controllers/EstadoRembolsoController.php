<?php

namespace App\Http\Controllers;

use App\Models\EstadoRembolso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstadoRembolsoController extends Controller
{
    public function addEstadoRembolso(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoEstadoRembolso = new EstadoRembolso();
            $tipoEstadoRembolso->name = $request->name;
            $tipoEstadoRembolso->id_empresa = $request->id_empresa;
            $tipoEstadoRembolso->save();

            return response()->json(
                [
                    'message'=> 'Tipo added Succeccfully',
                    'tipo_id' => $tipoEstadoRembolso->id
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }
    }

    public function editEstadoRembolso(Request $request){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoEstadoRembolso_data = EstadoRembolso::find($request->id);


           $updateEstadoRembolso = $tipoEstadoRembolso_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateEstadoRembolso,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function editEstadoRembolso2(Request $request,$id_tipo){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoEstadoRembolso_data = EstadoRembolso::find($id_tipo);


           $updateEstadoRembolso = $tipoEstadoRembolso_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateEstadoRembolso,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function allEstadoRembolso(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsEstadoRembolso = EstadoRembolso::where('id_empresa', $request->id_empresa)->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsEstadoRembolso,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),
                ],403);
           }

    }

    public function deleteEstadoRembolso(Request $request, $id_tipo){

        try{
            $tipoEstadoRembolso = EstadoRembolso::find($id_tipo);
            $tipoEstadoRembolso->delete();
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


    public function deleteEstadoRembolso2(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
           ]);

          if($validated->fails()){
              return response()->json($validated->errors(),403);
          }

        try{
            $tipoEstadoRembolso = EstadoRembolso::find($request->id);
            $tipoEstadoRembolso->delete();
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

<?php

namespace App\Http\Controllers;

use App\Models\TipoContratista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoContratistaController extends Controller
{
    public function addTipoContratista(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoTipoContratista = new TipoContratista();
            $tipoTipoContratista->name = $request->name;
            $tipoTipoContratista->id_empresa = $request->id_empresa;
            $tipoTipoContratista->save();

            return response()->json(
                [
                    'message'=> 'Tipo added Succeccfully',
                    'tipo_id' => $tipoTipoContratista->id
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }
    }

    public function editTipoContratista(Request $request){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoTipoContratista_data = TipoContratista::find($request->id);


           $updateTipoContratista = $tipoTipoContratista_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateTipoContratista,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function editTipoContratista2(Request $request,$id_tipo){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoTipoContratista_data = TipoContratista::find($id_tipo);


           $updateTipoContratista = $tipoTipoContratista_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateTipoContratista,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function allTipoContratista(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsTipoContratista = TipoContratista::where('id_empresa', $request->id_empresa)->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsTipoContratista,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),
                ],403);
           }

    }

    public function deleteTipoContratista(Request $request, $id_tipo){

        try{
            $tipoTipoContratista = TipoContratista::find($id_tipo);
            $tipoTipoContratista->delete();
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


    public function deleteTipoContratista2(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
           ]);

          if($validated->fails()){
              return response()->json($validated->errors(),403);
          }

        try{
            $tipoTipoContratista = TipoContratista::find($request->id);
            $tipoTipoContratista->delete();
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

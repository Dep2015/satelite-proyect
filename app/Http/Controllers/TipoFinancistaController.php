<?php

namespace App\Http\Controllers;

use App\Models\TipoFinancista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoFinancistaController extends Controller
{
    public function addTipoFinancista(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoTipoFinancista = new TipoFinancista();
            $tipoTipoFinancista->name = $request->name;
            $tipoTipoFinancista->id_empresa = $request->id_empresa;
            $tipoTipoFinancista->save();

            return response()->json(
                [
                    'message'=> 'Tipo added Succeccfully',
                    'tipo_id' => $tipoTipoFinancista->id
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }
    }

    public function editTipoFinancista(Request $request){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoTipoFinancista_data = TipoFinancista::find($request->id);


           $updateTipoFinancista = $tipoTipoFinancista_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateTipoFinancista,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function editTipoFinancista2(Request $request,$id_tipo){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoTipoFinancista_data = TipoFinancista::find($id_tipo);


           $updateTipoFinancista = $tipoTipoFinancista_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateTipoFinancista,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function allTipoFinancista(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsTipoFinancista = TipoFinancista::where('id_empresa', $request->id_empresa)->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsTipoFinancista,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),
                ],403);
           }

    }

    public function deleteTipoFinancista(Request $request, $id_tipo){

        try{
            $tipoTipoFinancista = TipoFinancista::find($id_tipo);
            $tipoTipoFinancista->delete();
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


    public function deleteTipoFinancista2(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
           ]);

          if($validated->fails()){
              return response()->json($validated->errors(),403);
          }

        try{
            $tipoTipoFinancista = TipoFinancista::find($request->id);
            $tipoTipoFinancista->delete();
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

<?php

namespace App\Http\Controllers;

use App\Models\TipoGasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoGastoController extends Controller
{
    public function addTipoGasto(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoTipoGasto = new TipoGasto();
            $tipoTipoGasto->name = $request->name;
            $tipoTipoGasto->id_empresa = $request->id_empresa;
            $tipoTipoGasto->save();

            return response()->json(
                [
                    'message'=> 'Tipo added Succeccfully',
                    'tipo_id' => $tipoTipoGasto->id
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }
    }

    public function editTipoGasto(Request $request){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoTipoGasto_data = TipoGasto::find($request->id);


           $updateTipoGasto = $tipoTipoGasto_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateTipoGasto,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function editTipoGasto2(Request $request,$id_tipo){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoTipoGasto_data = TipoGasto::find($id_tipo);


           $updateTipoGasto = $tipoTipoGasto_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateTipoGasto,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function allTipoGasto(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsTipoGasto = TipoGasto::where('id_empresa', $request->id_empresa)->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsTipoGasto,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),
                ],403);
           }

    }

    public function deleteTipoGasto(Request $request, $id_tipo){

        try{
            $tipoTipoGasto = TipoGasto::find($id_tipo);
            $tipoTipoGasto->delete();
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


    public function deleteTipoGasto2(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
           ]);

          if($validated->fails()){
              return response()->json($validated->errors(),403);
          }

        try{
            $tipoTipoGasto = TipoGasto::find($request->id);
            $tipoTipoGasto->delete();
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

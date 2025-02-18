<?php

namespace App\Http\Controllers;

use App\Models\TipodeAtencion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipodeAtencionController extends Controller
{
    public function addTipodeAtencion(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try {
            
            $TipodeAtencion = new TipodeAtencion();
            $TipodeAtencion->name = $request->name;
            $TipodeAtencion->id_empresa = $request->id_empresa;
            $TipodeAtencion->save();

            return response()->json(
                [
                    'message'=> 'Tipo added Succeccfully',
                    'tipo_id' => $TipodeAtencion->id
                ],200 );


           } catch (\Exception $exception) {
            return response()->json([
                'error'=> $exception->getMessage(),  
                ],403);
           }
    }


    public function editTipodeAtencion(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id' => 'required|integer',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }



        try {
            $TipodeAtencion_data = TipodeAtencion::find($request->id);

            $updateTipodeAtencion = $TipodeAtencion_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo de Atención updated Succeccfully',
                    'updateTipodeAtencion' => $updateTipodeAtencion,
                ],200 );

        } catch (\Exception $exceptionedit) {
            return response()->json([
                'error'=> $exceptionedit->getMessage(),  
                ],403);
        }
    }


    public function editTipodeAtencion2(Request $request, $id_campo){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }



        try {
            $TipodeAtencion_data = TipodeAtencion::find($id_campo);

            $updateTipodeAtencion = $TipodeAtencion_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo de Atención updated Succeccfully',
                    'updateTipodeAtencion' => $updateTipodeAtencion,
                ],200 );

        } catch (\Exception $exceptionedit) {
            return response()->json([
                'error'=> $exceptionedit->getMessage(),  
                ],403);
        }
    }


    public function allTipodeAtencion(Request $request){
    
        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsTipodeAtencion = TipodeAtencion::where('id_empresa', $request->id_empresa)->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsTipodeAtencion,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),  
                ],403);
           }
    
    }


    
    public function deleteTipodeAtencion(Request $request, $id_campo){

        try{
            $TipodeAtencion = TipodeAtencion::find($id_campo);
            $TipodeAtencion->delete();
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



    public function deleteTipodeAtencion2(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

        try{
            $TipodeAtencion = TipodeAtencion::find($request->id);
            $TipodeAtencion->delete();
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

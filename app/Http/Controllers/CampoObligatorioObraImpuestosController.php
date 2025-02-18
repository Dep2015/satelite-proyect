<?php

namespace App\Http\Controllers;

use App\Models\CampoObligatorioObraImpuestos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampoObligatorioObraImpuestosController extends Controller
{
    public function addCampoObligatorioObraImpuestos(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'habilitardeshabilitar' => 'required|integer',
            'obligatorio' => 'required|integer',
            'id_empresa' => 'required|integer',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try {
            
            $CampoObligatorioObraImpuestos = new CampoObligatorioObraImpuestos();
            $CampoObligatorioObraImpuestos->name = $request->name;
            $CampoObligatorioObraImpuestos->habilitardeshabilitar = $request->habilitardeshabilitar;
            $CampoObligatorioObraImpuestos->obligatorio = $request->obligatorio;
            $CampoObligatorioObraImpuestos->id_empresa = $request->id_empresa;
            $CampoObligatorioObraImpuestos->save();

            return response()->json(
                [
                    'message'=> 'Tipo added Succeccfully',
                    'tipo_id' => $CampoObligatorioObraImpuestos->id
                ],200 );


           } catch (\Exception $exception) {
            return response()->json([
                'error'=> $exception->getMessage(),  
                ],403);
           }
    }


    public function editCampoObligatorioObraImpuestos(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'habilitardeshabilitar' => 'required|integer',
            'obligatorio' => 'required|integer',
            'id' => 'required|integer',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }



        try {
            $CampoObligatorioObraImpuestos_data = CampoObligatorioObraImpuestos::find($request->id);

            $updateCampoObligatorioObraImpuestos = $CampoObligatorioObraImpuestos_data->update([
                'name'=> $request->name,
                'habilitardeshabilitar' => $request->habilitardeshabilitar,
                'obligatorio' => $request->obligatorio,
            ]);

            return response()->json(
                [
                    'message'=> 'Campo Obligatorio updated Succeccfully',
                    'updateCampoObligatorioObraImpuestos' => $updateCampoObligatorioObraImpuestos,
                ],200 );

        } catch (\Exception $exceptionedit) {
            return response()->json([
                'error'=> $exceptionedit->getMessage(),  
                ],403);
        }
    }


    public function editCampoObligatorioObraImpuestos2(Request $request, $id_campo){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'habilitardeshabilitar' => 'required|integer',
            'obligatorio' => 'required|integer',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }



        try {
            $CampoObligatorioObraImpuestos_data = CampoObligatorioObraImpuestos::find($id_campo);

            $updateCampoObligatorioObraImpuestos = $CampoObligatorioObraImpuestos_data->update([
                'name'=> $request->name,
                'habilitardeshabilitar' => $request->habilitardeshabilitar,
                'obligatorio' => $request->obligatorio,
            ]);

            return response()->json(
                [
                    'message'=> 'Campo Obligatorio updated Succeccfully',
                    'updateCampoObligatorioObraImpuestos' => $updateCampoObligatorioObraImpuestos,
                ],200 );

        } catch (\Exception $exceptionedit) {
            return response()->json([
                'error'=> $exceptionedit->getMessage(),  
                ],403);
        }
    }


    public function allCampoObligatorioObraImpuestos(Request $request){
    
        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsCampoObligatorioObraImpuestos = CampoObligatorioObraImpuestos::where('id_empresa', $request->id_empresa)->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsCampoObligatorioObraImpuestos,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),  
                ],403);
           }
    
    }


    
    public function deleteCampoObligatorioObraImpuestos(Request $request, $id_campo){

        try{
            $CampoObligatorioObraImpuestos = CampoObligatorioObraImpuestos::find($id_campo);
            $CampoObligatorioObraImpuestos->delete();
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



    public function deleteCampoObligatorioObraImpuestos2(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
            ]);
           
           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

        try{
            $CampoObligatorioObraImpuestos = CampoObligatorioObraImpuestos::find($request->id);
            $CampoObligatorioObraImpuestos->delete();
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PestaVista;
use Illuminate\Support\Facades\Validator;

class PestaVistaController extends Controller
{
    public function allPestaVista(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsPestaVista = PestaVista::where('id_empresa', $request->id_empresa)->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsPestaVista,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),
                ],403);
           }

    }


    public function addPestaVista(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'habilitardeshabilitar' => 'required|integer',
            'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try {

            $CampoObligatorioObraImpuestos = new PestaVista();
            $CampoObligatorioObraImpuestos->name = $request->name;
            $CampoObligatorioObraImpuestos->habilitardeshabilitar = $request->habilitardeshabilitar;
            $CampoObligatorioObraImpuestos->id_empresa = $request->id_empresa;
            $CampoObligatorioObraImpuestos->save();

            return response()->json(
                [
                    'message'=> 'Pestañas added Succeccfully',
                    'tipo_id' => $CampoObligatorioObraImpuestos->id
                ],200 );


           } catch (\Exception $exception) {
            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);
           }
    }


    public function editPestaVista(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'habilitardeshabilitar' => 'required|integer',
            'id' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }



        try {
            $CampoObligatorioObraImpuestos_data = PestaVista::find($request->id);

            $updateCampoObligatorioObraImpuestos = $CampoObligatorioObraImpuestos_data->update([
                'name'=> $request->name,
                'habilitardeshabilitar' => $request->habilitardeshabilitar,
            ]);

            return response()->json(
                [
                    'message'=> 'Pestaña updated Succeccfully',
                    'updateCampoObligatorioObraImpuestos' => $updateCampoObligatorioObraImpuestos,
                ],200 );

        } catch (\Exception $exceptionedit) {
            return response()->json([
                'error'=> $exceptionedit->getMessage(),
                ],403);
        }
    }
}

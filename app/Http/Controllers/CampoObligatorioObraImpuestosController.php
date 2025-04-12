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

        try {
            $campo = CampoObligatorioObraImpuestos::findOrFail($id_campo);
            $campo->delete();

            return response()->json([
                'message' => 'Campo obligatorio eliminado con éxito'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'El campo con el ID proporcionado no existe'
            ], 404);

        } catch (\Exception $exceptiondelete) {
            return response()->json([
                'error' => 'Error al eliminar el campo obligatorio',
                'message' => $exceptiondelete->getMessage()
            ], 500);
        }
    }



    public function deleteCampoObligatorioObraImpuestos2(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'error' => 'Error de validación',
                'messages' => $validated->errors()
            ], 403);
        }

        try {
            $campo = CampoObligatorioObraImpuestos::findOrFail($request->id);
            $campo->delete();

            return response()->json([
                'message' => 'Campo obligatorio eliminado con éxito'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'El campo obligatorio con el ID proporcionado no existe'
            ], 404);

        } catch (\Exception $exceptiondelete) {
            return response()->json([
                'error' => 'Error al eliminar el campo obligatorio',
                'message' => $exceptiondelete->getMessage()
            ], 500);
        }
    }
}

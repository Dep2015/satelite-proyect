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

        try {
            $tipo = TipoFinancista::findOrFail($id_tipo);
            $tipo->delete();

            return response()->json([
                'message' => 'Tipo de financista eliminado con éxito'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'El tipo de financista con el ID proporcionado no existe'
            ], 404);

        } catch (\Exception $exceptiondelete) {
            return response()->json([
                'error' => 'Error al eliminar el tipo de financista',
                'message' => $exceptiondelete->getMessage()
            ], 500);
        }
    }


    public function deleteTipoFinancista2(Request $request){

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
            $tipo = TipoFinancista::findOrFail($request->id);
            $tipo->delete();

            return response()->json([
                'message' => 'Tipo de financista eliminado con éxito'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'El tipo de financista con el ID proporcionado no existe'
            ], 404);

        } catch (\Exception $exceptiondelete) {
            return response()->json([
                'error' => 'Error al eliminar el tipo de financista',
                'message' => $exceptiondelete->getMessage()
            ], 500);
        }
    }

}

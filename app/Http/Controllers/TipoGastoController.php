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

        try {
            $tipo = TipoGasto::findOrFail($id_tipo);
            $tipo->delete();

            return response()->json([
                'message' => 'Tipo de gasto eliminado con éxito'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'El tipo de gasto con el ID proporcionado no existe'
            ], 404);

        } catch (\Exception $exceptiondelete) {
            return response()->json([
                'error' => 'Error al eliminar el tipo de gasto',
                'message' => $exceptiondelete->getMessage()
            ], 500);
        }
    }


    public function deleteTipoGasto2(Request $request){

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
            $tipo = TipoGasto::findOrFail($request->id);
            $tipo->delete();

            return response()->json([
                'message' => 'Tipo de gasto eliminado con éxito'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'El tipo de gasto con el ID proporcionado no existe'
            ], 404);

        } catch (\Exception $exceptiondelete) {
            return response()->json([
                'error' => 'Error al eliminar el tipo de gasto',
                'message' => $exceptiondelete->getMessage()
            ], 500);
        }
    }

}

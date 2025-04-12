<?php

namespace App\Http\Controllers;

use App\Models\AccionEstadoAtencion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccionEstadoAtencionController extends Controller
{
    public function addAccionEstadoAtencion(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try {

            $AccionEstadoAtencion = new AccionEstadoAtencion();
            $AccionEstadoAtencion->name = $request->name;
            $AccionEstadoAtencion->id_empresa = $request->id_empresa;
            $AccionEstadoAtencion->save();

            return response()->json(
                [
                    'message'=> 'Acción added Succeccfully',
                    'tipo_id' => $AccionEstadoAtencion->id
                ],200 );


           } catch (\Exception $exception) {
            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);
           }
    }


    public function editAccionEstadoAtencion(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }



        try {
            $AccionEstadoAtencion_data = AccionEstadoAtencion::find($request->id);

            $updateAccionEstadoAtencion = $AccionEstadoAtencion_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Acción updated Succeccfully',
                    'updateAccionEstadoAtencion' => $updateAccionEstadoAtencion,
                ],200 );

        } catch (\Exception $exceptionedit) {
            return response()->json([
                'error'=> $exceptionedit->getMessage(),
                ],403);
        }
    }


    public function editAccionEstadoAtencion2(Request $request, $id_campo){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }



        try {
            $AccionEstadoAtencion_data = AccionEstadoAtencion::find($id_campo);

            $updateAccionEstadoAtencion = $AccionEstadoAtencion_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Acción updated Succeccfully',
                    'updateAccionEstadoAtencion' => $updateAccionEstadoAtencion,
                ],200 );

        } catch (\Exception $exceptionedit) {
            return response()->json([
                'error'=> $exceptionedit->getMessage(),
                ],403);
        }
    }


    public function allAccionEstadoAtencion(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsAccionEstadoAtencion = AccionEstadoAtencion::where('id_empresa', $request->id_empresa)->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsAccionEstadoAtencion,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),
                ],403);
           }

}



public function deleteAccionEstadoAtencion(Request $request, $id_campo){

    try {
        $accion = AccionEstadoAtencion::findOrFail($id_campo);

        $accion->delete();

        return response()->json([
            'message' => 'Acción eliminada con éxito'
        ], 200);

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'error' => 'La acción con el ID proporcionado no existe'
        ], 404);

    } catch (\Exception $exceptiondelete) {
        return response()->json([
            'error' => 'Error al eliminar la acción',
            'message' => $exceptiondelete->getMessage()
        ], 500);
    }
}



public function deleteAccionEstadoAtencion2(Request $request){

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
        $accion = AccionEstadoAtencion::findOrFail($request->id);

        $accion->delete();

        return response()->json([
            'message' => 'Acción eliminada con éxito'
        ], 200);

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'error' => 'La acción con el ID proporcionado no existe'
        ], 404);

    } catch (\Exception $exceptiondelete) {
        return response()->json([
            'error' => 'Error al eliminar la acción',
            'message' => $exceptiondelete->getMessage()
        ], 500);
    }
}

}

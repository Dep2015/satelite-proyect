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

    try{
        $AccionEstadoAtencion = AccionEstadoAtencion::find($id_campo);
        $AccionEstadoAtencion->delete();
        return response()->json(
            [
                'message'=> 'Acción delete Succeccfully'
            ],200 );


    } catch(\Exception $exceptiondelete){
        return response()->json([
            'error'=> $exceptiondelete->getMessage(),  
            ],403);
    }
}



public function deleteAccionEstadoAtencion2(Request $request){

    $validated = Validator::make($request->all(), [
        'id' => 'required|integer',
        ]);
       
       if($validated->fails()){
           return response()->json($validated->errors(),403);
       }

    try{
        $AccionEstadoAtencion = AccionEstadoAtencion::find($request->id);
        $AccionEstadoAtencion->delete();
        return response()->json(
            [
                'message'=> 'Acción delete Succeccfully'
            ],200 );


    } catch(\Exception $exceptiondelete){
        return response()->json([
            'error'=> $exceptiondelete->getMessage(),  
            ],403);
    }
}

}
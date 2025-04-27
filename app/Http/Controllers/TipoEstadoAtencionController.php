<?php

namespace App\Http\Controllers;

use App\Models\TipoEstadoAtencion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TipoEstadoAtencionController extends Controller
{
    public function addTipoEstadoAtencion(Request $request){
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoEstadoAtencion = new TipoEstadoAtencion();
            $tipoEstadoAtencion->name = $request->name;
            $tipoEstadoAtencion->id_empresa = $request->id_empresa;
            $tipoEstadoAtencion->save();

            return response()->json(
                [
                    'message'=> 'Tipo added Succeccfully',
                    'tipo_id' => $tipoEstadoAtencion->id
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }
    }

    public function editTipoEstadoAtencion(Request $request){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoEstadoAtencion_data = TipoEstadoAtencion::find($request->id);


           $updateTipoEstadoAtencion = $tipoEstadoAtencion_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateTipoEstadoAtencion,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function editTipoEstadoAtencion2(Request $request,$id_tipo){

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipoEstadoAtencion_data = TipoEstadoAtencion::find($id_tipo);


           $updateTipoEstadoAtencion = $tipoEstadoAtencion_data->update([
                'name'=> $request->name,
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'updated_tipoestadoatencion' => $updateTipoEstadoAtencion,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }


    public function allTipoEstadoAtencion(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsTipoEstadoAtencion = TipoEstadoAtencion::where('id_empresa', $request->id_empresa)->where('estado', 1)->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsTipoEstadoAtencion,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),
                ],403);
           }

    }

    public function deleteTipoEstadoAtencion(Request $request, $id_tipo){

     //   try {
     //       $tipoEstadoAtencion = TipoEstadoAtencion::findOrFail($id_tipo);
     //       $tipoEstadoAtencion->delete();

     //       return response()->json([
     //           'message' => 'Tipo de estado de atención eliminado con éxito'
     //       ], 200);

    //    } catch (ModelNotFoundException $e) {
    //        return response()->json([
    //            'error' => 'El tipo de estado de atención con el ID proporcionado no existe'
    //        ], 404);

     //   } catch (\Exception $exceptiondelete) {
     //       return response()->json([
     //           'error' => 'Error al eliminar el tipo de estado de atención',
     //           'message' => $exceptiondelete->getMessage()
     //       ], 500);
     //   }

     try{

        $tipoEstadoAtencion_data = TipoEstadoAtencion::find($id_tipo);


       $updateTipoEstadoAtencion = $tipoEstadoAtencion_data->update([
            'estado'=> 0,
        ]);

        return response()->json(
            [
                'message'=> 'Tipo delete Succeccfully',
            //    'updated_tipoestadoatencion' => $updateTipoEstadoAtencion,
            ],200 );

       }catch(\Exception $exception){

        return response()->json([
            'error'=> $exception->getMessage(),
            ],403);

       }


    }


    public function deleteTipoEstadoAtencion2(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'error' => 'Error de validación',
                'messages' => $validated->errors()
            ], 403);
        }

      //  try {
      //      $tipoEstadoAtencion = TipoEstadoAtencion::findOrFail($request->id);
      //      $tipoEstadoAtencion->delete();

      //      return response()->json([
      //          'message' => 'Tipo de estado de atención eliminado con éxito'
      //      ], 200);

     //   } catch (ModelNotFoundException $e) {
     //       return response()->json([
     //           'error' => 'El tipo de estado de atención con el ID proporcionado no existe'
     //       ], 404);

     //   } catch (\Exception $exceptiondelete) {
     //       return response()->json([
     //           'error' => 'Error al eliminar el tipo de estado de atención',
     //           'message' => $exceptiondelete->getMessage()
     //       ], 500);
     //   }

     try{

        $tipoEstadoAtencion_data = TipoEstadoAtencion::find($request->id);


       $updateTipoEstadoAtencion = $tipoEstadoAtencion_data->update([
            'estado'=> 0,
        ]);

        return response()->json(
            [
                'message'=> 'Tipo delete Succeccfully',
               // 'updated_tipoestadoatencion' => $updateTipoEstadoAtencion,
            ],200 );

       }catch(\Exception $exception){

        return response()->json([
            'error'=> $exception->getMessage(),
            ],403);

       }

    }


}

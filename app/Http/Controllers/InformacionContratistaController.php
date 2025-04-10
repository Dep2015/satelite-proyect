<?php

namespace App\Http\Controllers;

use App\Models\InformacionContratista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InformacionContratistaController extends Controller
{
    public function addInformacionContratista(Request $request)
    {
        $validated = Validator::make($request->all(), [

            'id_tipo_contratista' => 'required|exists:tipo_contratistas,id',
            'aspecto' => 'required|string|max:255',
            'comentarios' => 'required|string',
            'id_categoria_documento' => 'required|nullable|array',
            'id_categoria_documento.*.id' => 'required|integer',
            'id_categoria_documento.*.nombre' => 'required|string|max:255',
            'responsables' => 'required|nullable|array',
            'responsables.*.id' => 'required|integer',
            'responsables.*.nombre' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 403);
        }

        try {

            $contratista = new InformacionContratista();
            $contratista->id_tipo_contratista = $request->id_tipo_contratista;
            $contratista->aspecto = $request->aspecto;
            $contratista->comentarios = $request->comentarios;
            $contratista->id_categoria_documento = $request->id_categoria_documento;
            $contratista->responsables = $request->responsables;
            $contratista->id_empresa = $request->id_empresa;
            $contratista->save();

            return response()->json([
                'message' => 'Pago ingresado con éxito',
                'obra_id' => $contratista->id
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }


    public function editInformacionContratista(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
            'id_tipo_contratista' => 'required|exists:tipo_contratistas,id',
            'aspecto' => 'required|string|max:255',
            'comentarios' => 'required|string',
            'id_categoria_documento' => 'required|nullable|array',
            'id_categoria_documento.*.id' => 'required|integer',
            'id_categoria_documento.*.nombre' => 'required|string|max:255',
            'responsables' => 'required|nullable|array',
            'responsables.*.id' => 'required|integer',
            'responsables.*.nombre' => 'required|string|max:255',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $tipocontratista_data = InformacionContratista::find($request->id);


           $updatecontratista = $tipocontratista_data->update([
                'id_tipo_contratista' => $request->id_tipo_contratista,
                'aspecto' => $request->aspecto,
                'comentarios' => $request->comentarios,
                'id_categoria_documento' => json_encode($request->id_categoria_documento),
                'responsables' => json_encode($request->responsables),
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'data' => $updatecontratista,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }



    public function deleteInformacionContratista(Request $request)
{
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
        $contratista = InformacionContratista::findOrFail($request->id);
        $contratista->delete();

        return response()->json([
            'message' => 'Pago eliminado con éxito'
        ], 200);

    } catch (\Exception $exceptiondelete) {
        return response()->json([
            'error' => 'Error al eliminar el pago',
            'message' => $exceptiondelete->getMessage()
        ], 500);
    }
}


public function allInformacionContratista(Request $request)
{
    // Validar la entrada
    $validated = Validator::make($request->all(), [
        'id_empresa' => 'required|integer',
    ]);

    if ($validated->fails()) {
        return response()->json([
            'error' => 'Error de validación',
            'messages' => $validated->errors()
        ], 403);
    }

    try {
        // Obtener los pagos de la empresa especificada con relaciones si las hay
        $itemsPagosOI = InformacionContratista::where('id_empresa', $request->id_empresa)->with(['tipocontratista:id,name'])->get();

        return response()->json([
            'success' => true,
            'data' => $itemsPagosOI
        ], 200);

    } catch (\Exception $exceptionall) {
        return response()->json([
            'error' => 'Error al obtener los pagos',
            'message' => $exceptionall->getMessage()
        ], 500);
    }
}

}

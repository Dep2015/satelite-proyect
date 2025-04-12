<?php

namespace App\Http\Controllers;

use App\Models\InformacionFinancista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InformacionFinancistaController extends Controller
{
    public function addInformacionFinancista(Request $request)
    {
        $validated = Validator::make($request->all(), [

            'id_tipo_financista' => 'required|exists:tipo_financistas,id',
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

            $financista = new InformacionFinancista();
            $financista->id_tipo_financista = $request->id_tipo_financista;
            $financista->aspecto = $request->aspecto;
            $financista->comentarios = $request->comentarios;
            $financista->id_categoria_documento = $request->id_categoria_documento;
            $financista->responsables = $request->responsables;
            $financista->id_empresa = $request->id_empresa;
            $financista->save();

            return response()->json([
                'message' => 'financista ingresado con éxito',
                'obra_id' => $financista->id
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }


    public function editInformacionFinancista(Request $request){

        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
            'id_tipo_financista' => 'required|exists:tipo_financistas,id',
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

            $tipoFinancista_data = InformacionFinancista::find($request->id);


           $updateFinancista = $tipoFinancista_data->update([
                'id_tipo_financista' => $request->id_tipo_financista,
                'aspecto' => $request->aspecto,
                'comentarios' => $request->comentarios,
                'id_categoria_documento' => json_encode($request->id_categoria_documento),
                'responsables' => json_encode($request->responsables),
            ]);

            return response()->json(
                [
                    'message'=> 'Tipo updated Succeccfully',
                    'data' => $updateFinancista,
                ],200 );

           }catch(\Exception $exception){

            return response()->json([
                'error'=> $exception->getMessage(),
                ],403);

           }

    }



    public function deleteInformacionFinancista(Request $request)
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
        $financista = InformacionFinancista::findOrFail($request->id);
        $financista->delete();

        return response()->json([
            'message' => 'Financista eliminado con éxito'
        ], 200);

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'error' => 'El financista con el ID proporcionado no existe'
        ], 404);

    } catch (\Exception $exceptiondelete) {
        return response()->json([
            'error' => 'Error al eliminar el financista',
            'message' => $exceptiondelete->getMessage()
        ], 500);
    }
}


public function allInformacionFinancista(Request $request)
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
        $itemsPagosOI = InformacionFinancista::where('id_empresa', $request->id_empresa)->with(['tipoFinancista:id,name'])->get();

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

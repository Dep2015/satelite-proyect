<?php

namespace App\Http\Controllers;

use App\Models\ObraImpuestos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObraImpuestoController extends Controller
{
    public function addObraImpuesto(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'tipo_id' => 'required|exists:tipo_estado_atencions,id',
            'fecha_conclusion' => 'date',
            'fecha_reembolso' => 'date',
            'responsable' => 'required|integer',
            'unidades_gestion' => 'nullable|array',
            'unidades_gestion.*' => 'integer',
            'centros_operacion' => 'nullable|array',
            'centros_operacion.*' => 'integer',
            'id_empresa' => 'integer',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 403);
        }

        try {
            $obra = new ObraImpuestos();
            $obra->nombre = $request->nombre;
            $obra->tipo_id = $request->tipo_id;
            $obra->fecha_conclusion = $request->fecha_conclusion;
            $obra->fecha_reembolso = $request->fecha_reembolso;
            $obra->responsable = $request->responsable;
            $obra->unidades_gestion = json_encode($request->unidades_gestion);
            $obra->centros_operacion = json_encode($request->centros_operacion);
            $obra->id_empresa = $request->id_empresa;
            $obra->save();

            return response()->json([
                'message' => 'Obra creada con éxito',
                'obra_id' => $obra->id
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }


    public function allObraImpuesto(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id_empresa' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 403);
        }

        try {
            $obras = ObraImpuestos::where('id_empresa', $request->id_empresa)->with(['tipo'])->get()->map(function ($obra) {
                return [
                    'id' => $obra->id,
                    'nombre' => $obra->nombre,
                    'tipo_id' => [
                        'id' => $obra->tipo_id,
                        'nombre' => $obra->tipo->nombre ?? null
                    ],
                    'fecha_conclusion' => $obra->fecha_conclusion,
                    'fecha_reembolso' => $obra->fecha_reembolso,
                    'responsable' => $obra->responsable,
                    'unidades_gestion' => json_decode($obra->unidades_gestion),
                    'centros_operacion' => json_decode($obra->centros_operacion),
                    'id_empresa' => $obra->id_empresa,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $obras
            ], 200);

        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 403);
        }
    }




}

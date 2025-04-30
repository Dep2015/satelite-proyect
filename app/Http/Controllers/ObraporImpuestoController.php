<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\ObraporImpuesto;
use App\Models\ActividadesEjecucion;
use App\Models\ActividadEstadoAtencion;
use App\Models\InformacionFinancista;
use App\Models\InformacionContratista;
use App\Models\Archivos3;
use App\Models\PagosOI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObraporImpuestoController extends Controller
{
    public function addObraporImpuesto(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'tipo_id' => 'required|exists:tipo_estado_atencions,id',
            'estado_id' => 'required|exists:atencion_estados,id',
            'costo_proyecto' => 'required|numeric|min:0',
            'fecha_conclusion' => 'required|date',
            'fecha_reembolso' => 'required|date',
            'responsable' => 'required|nullable|array',
            'responsable.*.id' => 'required|integer',
            'responsable.*.nombre' => 'required|string|max:255',
            'unidades_gestion' => 'required|nullable|array',
            'unidades_gestion.*.id' => 'required|integer',
            'unidades_gestion.*.nombre' => 'required|string|max:255',
            'centros_operacion' => 'required|nullable|array',
            'centros_operacion.*.id' => 'required|integer',
            'centros_operacion.*.nombre' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 403);
        }

        try {

            $obra = new ObraporImpuesto();
            $obra->nombre = $request->nombre;
            $obra->tipo_id = $request->tipo_id;
            $obra->estado_id = $request->estado_id;
            $obra->costo_proyecto = $request->costo_proyecto;
            $obra->fecha_conclusion = $request->fecha_conclusion;
            $obra->fecha_reembolso = $request->fecha_reembolso;
            $obra->responsable = $request->responsable;
            $obra->unidades_gestion = $request->unidades_gestion;
            $obra->centros_operacion = $request->centros_operacion;
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

/// actual
public function addObraporImpuestov2(Request $request)
{
    $validated = Validator::make($request->all(), [
        'nombre' => 'required|string|max:255',
        'tipo_id' => 'required|exists:tipo_estado_atencions,id',
        'estado_id' => 'required|exists:atencion_estados,id',
        'costo_proyecto' => 'required|numeric|min:0',
        'fecha_conclusion' => 'required|date',
        'fecha_reembolso' => 'required|date',
        'responsable' => 'required|nullable|array',
        'responsable.*.id' => 'required|integer',
        'responsable.*.nombre' => 'required|string|max:255',
        'unidades_gestion' => 'required|nullable|array',
        'unidades_gestion.*.id' => 'required|integer',
        'unidades_gestion.*.nombre' => 'required|string|max:255',
        'centros_operacion' => 'required|nullable|array',
        'centros_operacion.*.id' => 'required|integer',
        'centros_operacion.*.nombre' => 'required|string|max:255',
        'id_empresa' => 'required|integer',
    ]);

    if ($validated->fails()) {
        return response()->json($validated->errors(), 403);
    }

    try {
        $obra = new ObraporImpuesto();
        $obra->nombre = $request->nombre;
        $obra->tipo_id = $request->tipo_id;
        $obra->estado_id = $request->estado_id;
        $obra->costo_proyecto = $request->costo_proyecto;
        $obra->fecha_conclusion = $request->fecha_conclusion;
        $obra->fecha_reembolso = $request->fecha_reembolso;
        $obra->responsable = $request->responsable;
        $obra->unidades_gestion = $request->unidades_gestion;
        $obra->centros_operacion = $request->centros_operacion;
        $obra->id_empresa = $request->id_empresa;
        $obra->save();

        // Actividades predefinidas
        $actividadesBase = [
            [1, 'Aprobar la Capacidad Presupuestal', 1, 1],
            [2, 'Aprobar la Ejecución Conjunta de Proyectos', 1, 3],
            [3, 'Evaluar la Propuesta de Proyectos de Sector Privado', 1, 3],
            [4, 'Aprobar la Lista de Proyectos Priorizados por Entidad Pública', 1, 1],
            [1, 'Designar al Comité Especial', 2, 3],
            [2, 'Otorgar la Certificación Presupuestaría y/o compromiso', 2, 3],
            [3, 'Aprobar las bases para el proceso de selección', 2, 3],
            [1, 'Realizar el Proceso de Selección', 3, 1],
            [1, 'Realizar la suscripción de Convenio', 4, 1],
            [2, 'Realizar el suscripción de contrato de la Supervisión del Proyecto', 4, 1],
            [3, 'Realizar modificación de Estudios', 4, 1],
            [4, 'Aprobar el Estudio definitivo expediente de operación y/o mantenimiento', 4, 1],
            [5, 'Aprobar la Sustitución del Ejecutor de Proyecto', 4, 1],
            [6, 'Aprobar la ampliación de plazos', 4, 1],
            [7, 'Realizar la culminación y recepción del proyecto', 4, 1],
            [8, 'Aprobar la liquidación del proyecto', 4, 1],
            [9, 'Emitir conformidad de Mantenimiento u Operación', 4, 1],
            [1, 'Emitir el CIPRL o CIPGN', 5, 1],
            [2, 'Emitir el CIPRL o CIPGN por Avance de Obra', 5, 1],
        ];

        foreach ($actividadesBase as [$secuencia, $nombre, $atencionEstado, $tipoEstado]) {
            $yaExiste = ActividadesEjecucion::where('id_obra_impuesto', $obra->id)
                ->where('secuencia_id', $secuencia)
                ->where('name', $nombre)
                ->exists();

            if (!$yaExiste) {
                ActividadesEjecucion::create([
                    'secuencia_id' => $secuencia,
                    'name' => $nombre,
                    'fecha' => Carbon::now()->toDateString(),
                    'comentarios' => '',
                    'responsables' => [],
                    'id_empresa' => $obra->id_empresa,
                    'id_obra_impuesto' => $obra->id,
                    'atencion_estado_id' => $atencionEstado,
                    'tipo_estado_ejecucion_id' => $tipoEstado,
                ]);
            }
        }

        return response()->json([
            'message' => 'Obra y actividades creadas con éxito',
            'obra_id' => $obra->id
        ], 200);

    } catch (\Exception $exception) {
        return response()->json([
            'error' => $exception->getMessage(),
        ], 500);
    }
}


public function addObraporImpuestov3(Request $request)
{
    $validated = Validator::make($request->all(), [
        'nombre' => 'required|string|max:255',
        'tipo_id' => 'required|exists:tipo_estado_atencions,id',
        'estado_id' => 'required|exists:atencion_estados,id',
        'costo_proyecto' => 'required|numeric|min:0',
        'fecha_conclusion' => 'required|date',
        'fecha_reembolso' => 'required|date',
        'responsable' => 'required|nullable|array',
        'responsable.*.id' => 'required|integer',
        'responsable.*.nombre' => 'required|string|max:255',
        'unidades_gestion' => 'required|nullable|array',
        'unidades_gestion.*.id' => 'required|integer',
        'unidades_gestion.*.nombre' => 'required|string|max:255',
        'centros_operacion' => 'required|nullable|array',
        'centros_operacion.*.id' => 'required|integer',
        'centros_operacion.*.nombre' => 'required|string|max:255',
        'id_empresa' => 'required|integer',
    ]);

    if ($validated->fails()) {
        return response()->json($validated->errors(), 403);
    }

    try {
        $obra = new ObraporImpuesto();
        $obra->nombre = $request->nombre;
        $obra->tipo_id = $request->tipo_id;
        $obra->estado_id = $request->estado_id;
        $obra->costo_proyecto = $request->costo_proyecto;
        $obra->fecha_conclusion = $request->fecha_conclusion;
        $obra->fecha_reembolso = $request->fecha_reembolso;
        $obra->responsable = $request->responsable;
        $obra->unidades_gestion = $request->unidades_gestion;
        $obra->centros_operacion = $request->centros_operacion;
        $obra->id_empresa = $request->id_empresa;
        $obra->save();

        // Cargar todas las actividades existentes de la tabla ActividadEstadoAtencion
        $actividades = ActividadEstadoAtencion::all();

        foreach ($actividades as $actividad) {
            $yaExiste = ActividadesEjecucion::where('id_obra_impuesto', $obra->id)
                ->where('secuencia_id', $actividad->secuencia)
                ->where('name', $actividad->nombre)
                ->exists();

            if (!$yaExiste) {
                ActividadesEjecucion::create([
                    'secuencia_id' => $actividad->secuencia,
                    'name' => $actividad->nombre,
                    'fecha' => Carbon::now()->toDateString(),
                    'comentarios' => '',
                    'responsables' => [],
                    'id_empresa' => $obra->id_empresa,
                    'id_obra_impuesto' => $obra->id,
                    'atencion_estado_id' => $actividad->id_estado_atencion, // ← usar el de la tabla
                    'tipo_estado_ejecucion_id' => 1
                ]);
            }
        }

        return response()->json([
            'message' => 'Obra y actividades creadas con éxito',
            'obra_id' => $obra->id
        ], 200);

    } catch (\Exception $exception) {
        return response()->json([
            'error' => $exception->getMessage(),
        ], 500);
    }
}


    public function editObraporImpuesto(Request $request)
{
    // Validar los datos recibidos
    $validated = Validator::make($request->all(), [
        'id' => 'required|exists:obrapor_impuestos,id', // Validar que la obra exista
        'nombre' => 'required|string|max:255',
        'tipo_id' => 'required|exists:tipo_estado_atencions,id',
        'estado_id' => 'required|exists:atencion_estados,id',
        'costo_proyecto' => 'required|numeric|min:0',
        'fecha_conclusion' => 'required|date',
        'fecha_reembolso' => 'required|date',

        // Validación de responsable (array de objetos)
        'responsable' => 'nullable|array',
        'responsable.*.id' => 'required|integer',
        'responsable.*.nombre' => 'required|string|max:255',

        // Validación de unidades de gestión (array de objetos)
        'unidades_gestion' => 'nullable|array',
        'unidades_gestion.*.id' => 'required|integer',
        'unidades_gestion.*.nombre' => 'required|string|max:255',

        // Validación de centros de operación (array de objetos)
        'centros_operacion' => 'nullable|array',
        'centros_operacion.*.id' => 'required|integer',
        'centros_operacion.*.nombre' => 'required|string|max:255',

    ]);

    // Si la validación falla, devolver error
    if ($validated->fails()) {
        return response()->json([
            'error' => 'Error de validación',
            'messages' => $validated->errors()
        ], 403);
    }

    try {
        // Buscar la obra en la base de datos
        $obra = ObraporImpuesto::findOrFail($request->id);

        // Actualizar los datos
        $obra->update([
            'nombre' => $request->nombre,
            'tipo_id' => $request->tipo_id,
            'estado_id' => $request->estado_id,
            'costo_proyecto' => $request->costo_proyecto,
            'fecha_conclusion' => $request->fecha_conclusion,
            'fecha_reembolso' => $request->fecha_reembolso,
            'responsable' => $request->responsable, // Guardar como JSON
            'unidades_gestion' => $request->unidades_gestion,
            'centros_operacion' => $request->centros_operacion,
        ]);

        return response()->json([
            'message' => 'Obra actualizada con éxito',
            'obra' => $obra
        ], 200);

    } catch (\Exception $exception) {
        return response()->json([
            'error' => 'Error al actualizar la obra',
            'message' => $exception->getMessage()
        ], 500);
    }
}


public function editObraporImpuestoEstado(Request $request)
{
    // Validar los datos recibidos
    $validated = Validator::make($request->all(), [
        'id' => 'required|exists:obrapor_impuestos,id', // Validar que la obra exista
        'tipo_id' => 'required|exists:tipo_estado_atencions,id',


    ]);

    // Si la validación falla, devolver error
    if ($validated->fails()) {
        return response()->json([
            'error' => 'Error de validación',
            'messages' => $validated->errors()
        ], 403);
    }

    try {
        // Buscar la obra en la base de datos
        $obra = ObraporImpuesto::findOrFail($request->id);

        // Actualizar los datos
        $obra->update([

            'tipo_id' => $request->tipo_id,

        ]);

        return response()->json([
            'message' => 'Estado de Obra actualizada con éxito',
            'obra' => $obra
        ], 200);

    } catch (\Exception $exception) {
        return response()->json([
            'error' => 'Error al actualizar el estado de la obra',
            'message' => $exception->getMessage()
        ], 500);
    }
}



    public function allObraporImpuesto(Request $request){

        $validated = Validator::make($request->all(), [
             'id_empresa' => 'required|integer',
            ]);

           if($validated->fails()){
               return response()->json($validated->errors(),403);
           }

           try{

            $itemsObraporImpuesto = ObraporImpuesto::where('id_empresa', $request->id_empresa)->where('estado', 1)->with(['estado:id,name', 'tipo:id,name'])->get();

            return response()->json(
                [
                    'success'=> true,
                    'data' => $itemsObraporImpuesto,
                ],200 );

           }catch(\Exception $exceptionall){
            return response()->json([
                'error'=> $exceptionall->getMessage(),
                ],403);
           }

    }

  /***  public function allObraporImpuestoCo(Request $request){
    $validated = Validator::make($request->all(), [
        'id_empresa' => 'required|integer',
        'centros_operacion' => 'nullable|array',
        'centros_operacion.*' => 'required|integer',
        'unidades_gestion' => 'nullable|array',
        'unidades_gestion.*' => 'required|integer',
        'modo' => 'nullable|string|in:A,O', // "A" (AND) o "O" (OR)
    ]);

    if ($validated->fails()) {
        return response()->json($validated->errors(), 403);
    }

    try {
        $query = ObraporImpuesto::where('id_empresa', $request->id_empresa)
                    ->where('estado', 1)
                    ->with(['estado:id,name', 'tipo:id,name']);

        $modo = $request->modo ?? 'A'; // Por defecto "A" (AND)

        $hasCentros = $request->filled('centros_operacion');
        $hasUnidades = $request->filled('unidades_gestion');

        if ($hasCentros && $hasUnidades) {
            if ($modo === 'A') {
                // Ambos (AND)
                $query->where(function ($q) use ($request) {
                    foreach ($request->centros_operacion as $centroId) {
                        $q->whereJsonContains('centros_operacion', ['id' => $centroId]);
                    }
                })->where(function ($q) use ($request) {
                    foreach ($request->unidades_gestion as $unidadId) {
                        $q->whereJsonContains('unidades_gestion', ['id' => $unidadId]);
                    }
                });
            } else {
                // Alguno (OR)
                $query->where(function ($q) use ($request) {
                    foreach ($request->centros_operacion as $centroId) {
                        $q->orWhereJsonContains('centros_operacion', ['id' => $centroId]);
                    }
                    foreach ($request->unidades_gestion as $unidadId) {
                        $q->orWhereJsonContains('unidades_gestion', ['id' => $unidadId]);
                    }
                });
            }
        } elseif ($hasCentros) {
            // Solo centros
            $query->where(function ($q) use ($request) {
                foreach ($request->centros_operacion as $centroId) {
                    $q->orWhereJsonContains('centros_operacion', ['id' => $centroId]);
                }
            });
        } elseif ($hasUnidades) {
            // Solo unidades
            $query->where(function ($q) use ($request) {
                foreach ($request->unidades_gestion as $unidadId) {
                    $q->orWhereJsonContains('unidades_gestion', ['id' => $unidadId]);
                }
            });
        }

        $itemsObraporImpuesto = $query->get();

        return response()->json([
            'success' => true,
            'data' => $itemsObraporImpuesto,
        ], 200);

    } catch (\Exception $exceptionall) {
        return response()->json([
            'error' => $exceptionall->getMessage(),
        ], 403);
    }

}*/ 

public function allObraporImpuestoCo1(Request $request)
{
    $validated = Validator::make($request->all(), [
        'id_empresa' => 'required|integer',
        'centros_operacion' => 'nullable|array',
        'centros_operacion.*' => 'required|integer',
        'unidades_gestion' => 'nullable|array',
        'unidades_gestion.*' => 'required|integer',
        'modo' => 'nullable|string|in:A,O', // "A" (AND) o "O" (OR)
    ]);

    if ($validated->fails()) {
        return response()->json($validated->errors(), 403);
    }

    try {
        $query = ObraporImpuesto::where('id_empresa', $request->id_empresa)
            ->where('estado', 1)
            ->with([
                'estados:id,name',
                'tipo:id,name',
            ])
            ->withSum('pagos', 'monto_pagado')           // Suma total de todos los pagos
            ->withSum('pagosTipoGasto1', 'monto_pagado'); // Suma de pagos donde id_tipo_gasto = 1

        $modo = $request->modo ?? 'A'; // Por defecto "A" (AND)

        $hasCentros = $request->filled('centros_operacion');
        $hasUnidades = $request->filled('unidades_gestion');

        if ($hasCentros && $hasUnidades) {
            if ($modo === 'A') {
                $query->where(function ($q) use ($request) {
                    foreach ($request->centros_operacion as $centroId) {
                        $q->whereJsonContains('centros_operacion', ['id' => $centroId]);
                    }
                })->where(function ($q) use ($request) {
                    foreach ($request->unidades_gestion as $unidadId) {
                        $q->whereJsonContains('unidades_gestion', ['id' => $unidadId]);
                    }
                });
            } else {
                $query->where(function ($q) use ($request) {
                    foreach ($request->centros_operacion as $centroId) {
                        $q->orWhereJsonContains('centros_operacion', ['id' => $centroId]);
                    }
                    foreach ($request->unidades_gestion as $unidadId) {
                        $q->orWhereJsonContains('unidades_gestion', ['id' => $unidadId]);
                    }
                });
            }
        } elseif ($hasCentros) {
            $query->where(function ($q) use ($request) {
                foreach ($request->centros_operacion as $centroId) {
                    $q->orWhereJsonContains('centros_operacion', ['id' => $centroId]);
                }
            });
        } elseif ($hasUnidades) {
            $query->where(function ($q) use ($request) {
                foreach ($request->unidades_gestion as $unidadId) {
                    $q->orWhereJsonContains('unidades_gestion', ['id' => $unidadId]);
                }
            });
        }

        $itemsObraporImpuesto = $query->get();

        // Aquí renombramos los campos para la respuesta
        $itemsObraporImpuesto = $itemsObraporImpuesto->map(function ($item) {
            return [
                'id' => $item->id,
                'nombre' => $item->nombre ?? null,
                'tipo_id' => $item->tipo?->id ?? null,
                'tipo_nombre' => $item->tipo?->name ?? null,
                'estado_id' => $item->estado_id ?? null,
                'estado_nombre' => $item->estados?->name ?? null,
                'costo_proyecto' => $item->costo_proyecto ?? 0,
                'fecha_conclusion' => $item->fecha_conclusion ?? null,
                'fecha_reembolso' => $item->fecha_reembolso ?? null,
                'responsable' => $item->responsable ?? [],
                'unidades_gestion' => $item->unidades_gestion ?? [],
                'centros_operacion' => $item->centros_operacion ?? [],
                'monto_pagado' => $item->pagos_sum_monto_pagado ?? 0,
                'monto_recuperado' => $item->pagos_tipo_gasto1_sum_monto_pagado ?? 0,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $itemsObraporImpuesto,
        ], 200);

    } catch (\Exception $exceptionall) {
        return response()->json([
            'error' => $exceptionall->getMessage(),
        ], 403);
    }
}


public function allObraporImpuestoCo(Request $request)
{
    $validated = Validator::make($request->query(), [
        'id_empresa' => 'required|integer',
        'centros_operacion' => 'nullable|array',
        'centros_operacion.*' => 'required|integer',
        'unidades_gestion' => 'nullable|array',
        'unidades_gestion.*' => 'required|integer',
        'modo' => 'nullable|string|in:A,O',
    ]);

    if ($validated->fails()) {
        return response()->json($validated->errors(), 403);
    }

    try {
        $query = ObraporImpuesto::where('id_empresa', $request->query('id_empresa'))
            ->where('estado', 1)
            ->with([
                'estados:id,name',
                'tipo:id,name',
            ])
            ->withSum('pagos', 'monto_pagado')
            ->withSum('pagosTipoGasto1', 'monto_pagado');

        $modo = $request->query('modo', 'A');

        // ¡Aquí viene el cambio!
        $centrosOperacion = $request->query('centros_operacion', []);
        $unidadesGestion = $request->query('unidades_gestion', []);

        // Normalizamos manualmente para asegurar que sean arrays de enteros
        $centrosOperacion = array_map('intval', (array) $centrosOperacion);
        $unidadesGestion = array_map('intval', (array) $unidadesGestion);

        $hasCentros = count($centrosOperacion) > 0;
        $hasUnidades = count($unidadesGestion) > 0;

        if ($hasCentros || $hasUnidades) {
            if ($hasCentros && $hasUnidades) {
                if ($modo === 'A') {
                    $query->where(function ($q) use ($centrosOperacion) {
                        foreach ($centrosOperacion as $centroId) {
                            $q->whereJsonContains('centros_operacion', ['id' => $centroId]);
                        }
                    })->where(function ($q) use ($unidadesGestion) {
                        foreach ($unidadesGestion as $unidadId) {
                            $q->whereJsonContains('unidades_gestion', ['id' => $unidadId]);
                        }
                    });
                } else {
                    $query->where(function ($q) use ($centrosOperacion, $unidadesGestion) {
                        foreach ($centrosOperacion as $centroId) {
                            $q->orWhereJsonContains('centros_operacion', ['id' => $centroId]);
                        }
                        foreach ($unidadesGestion as $unidadId) {
                            $q->orWhereJsonContains('unidades_gestion', ['id' => $unidadId]);
                        }
                    });
                }
            } elseif ($hasCentros) {
                $query->where(function ($q) use ($centrosOperacion) {
                    foreach ($centrosOperacion as $centroId) {
                        $q->orWhereJsonContains('centros_operacion', ['id' => $centroId]);
                    }
                });
            } elseif ($hasUnidades) {
                $query->where(function ($q) use ($unidadesGestion) {
                    foreach ($unidadesGestion as $unidadId) {
                        $q->orWhereJsonContains('unidades_gestion', ['id' => $unidadId]);
                    }
                });
            }
        }

        $itemsObraporImpuesto = $query->get();

        $itemsObraporImpuesto = $itemsObraporImpuesto->map(function ($item) {
            return [
                'id' => $item->id,
                'nombre' => $item->nombre ?? null,
                'tipo_id' => $item->tipo?->id ?? null,
                'tipo_nombre' => $item->tipo?->name ?? null,
                'estado_id' => $item->estado_id ?? null,
                'estado_nombre' => $item->estados?->name ?? null,
                'costo_proyecto' => $item->costo_proyecto ?? 0,
                'fecha_conclusion' => $item->fecha_conclusion ?? null,
                'fecha_reembolso' => $item->fecha_reembolso ?? null,
                'responsable' => $item->responsable ?? [],
                'unidades_gestion' => $item->unidades_gestion ?? [],
                'centros_operacion' => $item->centros_operacion ?? [],
                'monto_pagado' => $item->pagos_sum_monto_pagado ?? 0,
                'monto_recuperado' => $item->pagos_tipo_gasto1_sum_monto_pagado ?? 0,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $itemsObraporImpuesto,
        ], 200);

    } catch (\Exception $exceptionall) {
        return response()->json([
            'error' => $exceptionall->getMessage(),
        ], 403);
    }
}



    public function deleteObraporImpuesto(Request $request)
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
        // Buscar la obra en la base de datos
        $obra = ObraporImpuesto::findOrFail($request->id);

        // Actualizar los datos
        $obra->update([

            'estado' => 0,

        ]);

        return response()->json([
            'message' => 'Estado de Obra actualizada con éxito',
            'obra' => $obra
        ], 200);

    } catch (\Exception $exception) {
        return response()->json([
            'error' => 'Error al actualizar el estado de la obra',
            'message' => $exception->getMessage()
        ], 500);
    }

}

}

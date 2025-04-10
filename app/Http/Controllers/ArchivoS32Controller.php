<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archivoss32;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Aws\S3\S3Client;

class ArchivoS32Controller extends Controller
{
    public function __construct()
    {
        $this->bucket = env('AWS_BUCKET');

        $this->s3 = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }



public function subirArchivo(Request $request)
{
    $request->validate([
        'archivo' => 'required|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx',
        'categoria' => 'required|integer',
        'codigo_registro' => 'required|integer',
        'empresa_id' => 'required|integer',
        'tipo' => 'required|integer', // solo se guarda, no se usa para validar
        'carpeta_base' => 'required|string' // ej: pagos, reportes, comprobantes
    ]);

    $file = $request->file('archivo');
    $originalName = $file->getClientOriginalName();
    $extension = strtolower($file->getClientOriginalExtension());

    // Determinar carpeta según extensión del archivo
    if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
        $subcarpeta = 'imagenes';
    } elseif (in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
        $subcarpeta = 'documentos';
    } else {
        return response()->json(['error' => 'Extensión de archivo no válida.'], 422);
    }

    $carpetaBase = trim($request->carpeta_base, '/'); // limpiamos por si viene con slash
    $path = "{$carpetaBase}/{$subcarpeta}/" . Str::random(8) . "_" . $originalName;

    // Subir archivo a S3
    $this->s3->putObject([
        'Bucket' => $this->bucket,
        'Key'    => $path,
        'Body'   => file_get_contents($file),
    ]);

    // Guardar en base de datos
    $archivo = Archivoss32::create([
        'nombre_original'   => $originalName,
        'path'              => $path,
        'tipo'              => $request->tipo,
        'categoria'         => $request->categoria,
        'codigo_registro'   => $request->codigo_registro,
        'empresa_id'        => $request->empresa_id,
    ]);

    return response()->json(['archivo' => $archivo], 201);
}

}

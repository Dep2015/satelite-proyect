<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Archivos3;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Aws\S3\S3Client;

class Archivos3Controller extends Controller
{
    protected $s3;
    protected $bucket;

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

    public function subirPago(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx',
            'categoria' => 'required|integer',
            'codigo_registro' => 'required|integer',
            'empresa_id' => 'required|integer',
            'tipo' => 'required|integer' // solo se guarda, NO se usa para validar
        ]);

        $file = $request->file('archivo');
        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());

        // Determinar carpeta según extensión del archivo
        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $carpeta = 'imagenes';
        } elseif (in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
            $carpeta = 'documentos';
        } else {
            return response()->json(['error' => 'Extensión de archivo no válida.'], 422);
        }

        // Generar path en S3 según carpeta
        $path = "pagos/{$carpeta}/" . Str::random(8) . "_" . $originalName;

        // Subir archivo a S3
        $this->s3->putObject([
            'Bucket' => $this->bucket,
            'Key'    => $path,
            'Body'   => file_get_contents($file),
        ]);

        // Guardar en base de datos (guardamos el tipo numérico tal como vino del frontend)
        $archivo = Archivos3::create([
            'nombre_original'   => $originalName,
            'path'              => $path,
            'tipo'              => $request->tipo, // guardamos el número tal cual
            'categoria'         => $request->categoria,
            'codigo_registro'   => $request->codigo_registro,
            'empresa_id'        => $request->empresa_id,
        ]);

        return response()->json(['archivo' => $archivo], 201);
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
    $archivo = Archivos3::create([
        'nombre_original'   => $originalName,
        'path'              => $path,
        'tipo'              => $request->tipo,
        'categoria'         => $request->categoria,
        'codigo_registro'   => $request->codigo_registro,
        'empresa_id'        => $request->empresa_id,
    ]);

    return response()->json(['archivo' => $archivo], 201);
}


    public function listarArchvio21(Request $request)
    {
        $request->validate([
            'codigo_registro' => 'required|integer',
            'empresa_id' => 'required|integer',
            'carpeta_base' => 'required|string'
        ]);

        $carpetaBase = trim($request->carpeta_base, '/');

        $archivos = Archivos3::where('codigo_registro', $request->codigo_registro)
            ->where('empresa_id', $request->empresa_id)
            ->where('path', 'like', "{$carpetaBase}/%")
            ->get()
            ->map(function ($archivo) {
                $archivo->url = "https://s3.amazonaws.com/" . env('AWS_BUCKET') . "/{$archivo->path}";
                return $archivo;
            });

        return response()->json($archivos);
    }


    public function listarArchvio2(Request $request)
    {
        $request->validate([
            'codigo_registro' => 'required|integer',
            'empresa_id' => 'required|integer',
            'carpeta_base' => 'required|string'
        ]);

        $carpetaBase = trim($request->carpeta_base, '/');

        $archivos = Archivos3::where('codigo_registro', $request->codigo_registro)
            ->where('empresa_id', $request->empresa_id)
            ->where('path', 'like', "{$carpetaBase}/%")
            ->get()
            ->map(function ($archivo) {
                $extension = strtolower(pathinfo($archivo->path, PATHINFO_EXTENSION));

                // URL pública directa (asumimos que el bucket permite lectura pública)
                $archivo->url = "https://{$this->bucket}.s3.amazonaws.com/{$archivo->path}";

                $archivo->esImagen = in_array($extension, ['jpg', 'jpeg', 'png']);
                $archivo->esPDF = $extension === 'pdf';

                return $archivo;
            });

        return response()->json($archivos);
    }

    public function listarArchivo(Request $request)
    {
        $request->validate([
            'codigo_registro' => 'required|integer',
            'empresa_id' => 'required|integer',
            'carpeta_base' => 'required|string'
        ]);

        $carpetaBase = trim($request->carpeta_base, '/');

        $archivos = Archivos3::where('codigo_registro', $request->codigo_registro)
            ->where('empresa_id', $request->empresa_id)
            ->where('path', 'like', "{$carpetaBase}/%")
            ->get()
            ->map(function ($archivo) {
                $extension = strtolower(pathinfo($archivo->path, PATHINFO_EXTENSION));

                // Generar URL firmada por 10 minutos
                $cmd = $this->s3->getCommand('GetObject', [
                    'Bucket' => $this->bucket,
                    'Key'    => $archivo->path,
                ]);
                $requestUrl = $this->s3->createPresignedRequest($cmd, '+10 minutes');
                $archivo->url = (string) $requestUrl->getUri();

                // Flags para usar en el frontend
                $archivo->esImagen = in_array($extension, ['jpg', 'jpeg', 'png']);
                $archivo->esPDF = $extension === 'pdf';

                return $archivo;
            });

        return response()->json($archivos);
    }


    public function eliminar(Request $request, $id)
    {
        $request->validate([
            'codigo_registro' => 'required|string',
        ]);

        $archivo = Archivos3::where('id', $id)
            ->where('codigo_registro', $request->codigo_registro)
            ->first();

        if (!$archivo) {
            return response()->json(['error' => 'Archivo no encontrado para ese código.'], 404);
        }

        $this->s3->deleteObject([
            'Bucket' => $this->bucket,
            'Key'    => $archivo->path,
        ]);

        $archivo->delete();

        return response()->json(['mensaje' => 'Archivo eliminado correctamente.']);
    }
}

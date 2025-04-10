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
            'tipo' => 'required|integer' // 1 = imagen, 2 = documento
        ]);

        $file = $request->file('archivo');
        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());

        // Determinar tipo real por la extensión
        $esImagen = in_array($extension, ['jpg', 'jpeg', 'png']);
        $esDocumento = in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx']);

        // Validar que el tipo enviado coincida con el tipo real
        if ($request->tipo == 1 && !$esImagen) {
            return response()->json(['error' => 'El archivo no es una imagen válida.'], 422);
        }

        if ($request->tipo == 2 && !$esDocumento) {
            return response()->json(['error' => 'El archivo no es un documento válido.'], 422);
        }

        // Definir carpeta según tipo enviado
        $carpeta = $request->tipo == 1 ? 'imagenes' : 'documentos';
        $path = "pagos/{$carpeta}/" . Str::random(8) . "_" . $originalName;

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
            'tipo'              => $request->tipo, // se guarda como número
            'categoria'         => $request->categoria,
            'codigo_registro'   => $request->codigo_registro,
            'empresa_id'        => $request->empresa_id,
        ]);

        return response()->json(['archivo' => $archivo], 201);
    }

    public function listarPago(Request $request)
    {
        $request->validate([
            'codigo_registro' => 'required|integer',
            'empresa_id' => 'required|integer',
        ]);

        $archivos = Archivos3::where('codigo_registro', $request->codigo_registro)
            ->where('empresa_id', $request->empresa_id)
            ->get()
            ->map(function ($archivo) {
                $archivo->url = "https://s3.amazonaws.com/" . env('AWS_BUCKET') . "/{$archivo->path}";
                return $archivo;
            });

        return response()->json($archivos);
    }

    public function eliminarPago(Request $request, $id)
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

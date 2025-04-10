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
        ]);

        $file = $request->file('archivo');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tipo = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']) ? 'imagenes' : 'documentos';

        $path = "pagos/{$tipo}/" . Str::random(8) . "_" . $originalName;

        $this->s3->putObject([
            'Bucket' => $this->bucket,
            'Key'    => $path,
            'Body'   => file_get_contents($file),
           // 'ACL'    => 'public-read',
        ]);

        $archivo = Archivo::create([
            'nombre_original' => $originalName,
            'path' => $path,
            'tipo' => $tipo,
            'categoria' => $request->categoria,
            'codigo_registro' => $request->codigo_registro,
            'empresa_id' => $request->empresa_id,
        ]);

        return response()->json(['archivo' => $archivo], 201);
    }

    public function listarPago(Request $request)
    {
        $request->validate([
            'codigo_registro' => 'required|integer',
            'empresa_id' => 'required|integer',
        ]);

        $archivos = Archivo::where('codigo_registro', $request->codigo_registro)
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

        $archivo = Archivo::where('id', $id)
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

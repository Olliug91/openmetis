<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ContextController extends Controller
{
    private function getBrainPath()
    {
        return rtrim(config('app.brain_path'), '/');
    }

    public function read(Request $request)
    {
        $request->validate(['file' => 'required|string']);
        $filePath = $this->getBrainPath() . '/' . ltrim($request->file, '/');
        
        if (!File::exists($filePath)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }
        
        return response()->json([
            'file' => $request->file,
            'content' => File::get($filePath)
        ]);
    }

    public function update(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'file' => 'required|string',
            'content' => 'required|string',
            'append' => 'boolean'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation failed: Faltan parámetros (file o content).',
                'data_received' => $request->all(),
                'validation_errors' => $validator->errors()
            ], 200);
        }
        
        $filePath = $this->getBrainPath() . '/' . ltrim($request->file, '/');
        $directory = dirname($filePath);
        
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        
        if ($request->boolean('append') && File::exists($filePath)) {
            File::append($filePath, "\n" . $request->content);
        } else {
            File::put($filePath, $request->content);
        }
        
        // Auto-sincronizar después de guardar para que no haya desincronización
        $this->sync(new Request());
        
        return response()->json(['success' => true, 'message' => 'Archivo actualizado y sincronizado']);
    }

    public function sync(Request $request)
    {
        $brainPath = $this->getBrainPath();
        
        if (!File::exists($brainPath . '/.git')) {
            return response()->json(['error' => 'No es un repositorio git'], 400);
        }
        
        $pat = config('openmetis.github_pat');
        
        $output = [];
        $returnVar = 0;
        
        // 1. Añadir cambios y hacer commit
        $commitCmd = "cd {$brainPath} && git config user.name 'OpenMetis AI' && git config user.email 'bot@openmetis.local' && git add . && git commit -m 'Auto-save desde OpenMetis AI' 2>&1";
        exec($commitCmd, $output, $returnVar);
        
        // Si no hay cambios que hacer commit (returnVar = 1), no es un error crítico
        
        // 2. Hacer Push
        $pushCmd = "cd {$brainPath} && ";
        if (!empty($pat)) {
            // Obtener la URL remota actual
            $remoteUrl = trim(shell_exec("cd {$brainPath} && git config --get remote.origin.url"));
            // Reemplazar la URL para inyectar el PAT temporalmente para este push
            if (str_starts_with($remoteUrl, 'https://')) {
                // Quitar credenciales si ya las tiene y poner el PAT
                $cleanUrl = preg_replace('/https:\/\/[^@]+@/', 'https://', $remoteUrl);
                $patUrl = str_replace('https://', "https://{$pat}@", $cleanUrl);
                $pushCmd .= "git push " . escapeshellarg($patUrl) . " main 2>&1";
            } else {
                $pushCmd .= "git push origin main 2>&1";
            }
        } else {
            $pushCmd .= "git push origin main 2>&1";
        }
        
        exec($pushCmd, $pushOutput, $pushReturnVar);
        $output = array_merge($output, $pushOutput);
        
        return response()->json([
            'success' => $pushReturnVar === 0,
            'output' => implode("\n", $output)
        ], $pushReturnVar === 0 ? 200 : 500);
    }
}

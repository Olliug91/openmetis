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
        $request->validate([
            'file' => 'required|string',
            'content' => 'required|string',
            'append' => 'boolean'
        ]);
        
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
        
        return response()->json(['success' => true, 'message' => 'Archivo actualizado']);
    }

    public function sync(Request $request)
    {
        $scriptPath = $this->getBrainPath() . '/scripts/sync-to-github.sh';
        
        if (!File::exists($scriptPath)) {
            return response()->json(['error' => 'Script de sync no encontrado'], 404);
        }
        
        // En un entorno real se ejecutaría con exec() o process, 
        // asumiendo permisos correctos.
        $output = [];
        $returnVar = 0;
        exec("bash " . escapeshellarg($scriptPath) . " 2>&1", $output, $returnVar);
        
        return response()->json([
            'success' => $returnVar === 0,
            'output' => implode("\n", $output)
        ], $returnVar === 0 ? 200 : 500);
    }
}

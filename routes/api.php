<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/context', function () {
    $cerebroPath = rtrim(config('app.brain_path', storage_path('app/cerebro')), '/');
    
    if (!File::exists($cerebroPath)) {
        return response()->json(['system_prompt' => '']);
    }

    $prompt = config('openmetis.system_prompt');

    $files = File::allFiles($cerebroPath);
    
    $allowedExtensions = array_map('trim', explode(',', config('openmetis.allowed_extensions', 'md,txt')));
    $defaultExclusions = ['ufc_', 'n8n_', 'historico_', 'daw/', 'scripts/', 'proyectos/', '.git/'];
    $envExclusions = array_map('trim', explode(',', config('openmetis.excluded_files', '')));
    $excludedFiles = array_unique(array_filter(array_merge($defaultExclusions, $envExclusions)));
    
    foreach ($files as $file) {
        $relativePath = str_replace('\\', '/', $file->getRelativePathname());
        $filename = $file->getFilename();
        $extension = $file->getExtension();
        
        // Comprobar si el archivo está en la lista de exclusiones (por nombre exacto, prefijo o directorio)
        $isExcluded = false;
        foreach ($excludedFiles as $excluded) {
            if (!empty($excluded)) {
                if (str_starts_with($filename, $excluded) || 
                    str_starts_with($relativePath, $excluded) || 
                    str_contains($relativePath, '/' . rtrim($excluded, '/') . '/')) {
                    $isExcluded = true;
                    break;
                }
            }
        }
        
        if ($isExcluded) {
            continue;
        }

        // Límite de seguridad: nunca cargar archivos individuales > 100KB en el prompt base
        if ($file->getSize() > 100000) {
            continue;
        }

        if (in_array($extension, $allowedExtensions)) {
            $prompt .= "--- Inicio de archivo: " . $relativePath . " ---\n";
            $prompt .= file_get_contents($file->getPathname()) . "\n";
            $prompt .= "--- Fin de archivo ---\n\n";
        }
    }

    return response()->json([
        'system_prompt' => $prompt
    ]);
});

Route::post('/deploy', function (Request $request) {
    $secret = config('openmetis.github_webhook_secret');
    if (!empty($secret)) {
        $signature = $request->header('X-Hub-Signature-256');
        $hash = 'sha256=' . hash_hmac('sha256', $request->getContent(), $secret);
        if (!hash_equals($hash, $signature ?? '')) {
            return response()->json(['error' => 'Invalid signature'], 403);
        }
    }

    $path = rtrim(config('app.brain_path', storage_path('app/cerebro')), '/');
    
    // Si la carpeta es un repositorio git, hacemos pull seguro
    if (File::exists($path . '/.git')) {
        $cmd = "cd {$path} && git add . && git commit -m 'Auto-save VPS' || true && git pull --rebase origin main 2>&1";
        $output = shell_exec($cmd);
        return response()->json(['status' => 'success', 'output' => $output]);
    }

    return response()->json(['status' => 'error', 'message' => 'El repositorio git no está inicializado en storage/app/cerebro'], 400);
});

Route::get('/ufc', function (Request $request) {
    $fighter = $request->query('fighter');
    if (!$fighter) {
        return response()->json(['error' => 'Fighter name required'], 400);
    }
    $brainPath = rtrim(config('app.brain_path', storage_path('app/cerebro')), '/');
    $scriptPath = $brainPath . '/scripts/consultar_ufc.py';
    $command = "python3 " . escapeshellarg($scriptPath) . " " . escapeshellarg($fighter);
    $output = shell_exec($command);
    
    return response($output)->header('Content-Type', 'text/plain');
});

Route::get('/taekwondo', function (Request $request) {
    $query = $request->query('query', '');
    $brainPath = rtrim(config('app.brain_path', storage_path('app/cerebro')), '/');
    $scriptPath = $brainPath . '/scripts/consultar_taekwondo.py';
    
    if (!File::exists($scriptPath)) {
        return response("Script consultar_taekwondo.py no encontrado.", 404)->header('Content-Type', 'text/plain');
    }
    
    $command = "python3 " . escapeshellarg($scriptPath) . " " . escapeshellarg($query);
    $output = shell_exec($command);
    
    return response($output ?? 'Sin resultados')->header('Content-Type', 'text/plain');
});

Route::get('/daw', function (Request $request) {
    $query = $request->query('query', '');
    $brainPath = rtrim(config('app.brain_path', storage_path('app/cerebro')), '/');
    $scriptPath = $brainPath . '/scripts/consultar_daw.py';
    
    if (!File::exists($scriptPath)) {
        return response("Script consultar_daw.py no encontrado.", 404)->header('Content-Type', 'text/plain');
    }
    
    $command = "python3 " . escapeshellarg($scriptPath) . " " . escapeshellarg($query);
    $output = shell_exec($command);
    
    return response($output ?? 'Sin resultados')->header('Content-Type', 'text/plain');
});

use App\Http\Controllers\ContextController;

Route::middleware('api.token')->group(function () {
    Route::get('/context/read', [ContextController::class, 'read']);
    // Route::get('/context/search', [ContextController::class, 'search']); // TODO
    Route::post('/context/update', [ContextController::class, 'update']);
    Route::post('/system/sync', [ContextController::class, 'sync']);
});

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

    $prompt = "Eres el asistente personal 'Cerebro de Bolsillo'. Utiliza el siguiente contexto personal para responder a las preguntas del usuario:\n\n";

    $files = File::allFiles($cerebroPath);
    
    foreach ($files as $file) {
        $filename = $file->getFilename();
        $extension = $file->getExtension();
        
        // Ignorar los JSON gigantes de la UFC y el backup de n8n para no saturar los tokens
        if (str_starts_with($filename, 'ufc_') || $filename === 'n8n_nexus_workflow.json') {
            continue;
        }

        if (in_array($extension, ['md', 'json'])) {
            $prompt .= "--- Inicio de archivo: " . $filename . " ---\n";
            $prompt .= file_get_contents($file->getPathname()) . "\n";
            $prompt .= "--- Fin de archivo ---\n\n";
        }
    }

    return response()->json([
        'system_prompt' => $prompt
    ]);
});

Route::post('/deploy', function (Request $request) {
    // Aquí puedes añadir validación de un secret token de GitHub si lo deseas
    // if ($request->header('X-Hub-Signature-256') !== ...) { ... }

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

use App\Http\Controllers\ContextController;

Route::middleware('api.token')->group(function () {
    Route::get('/context/read', [ContextController::class, 'read']);
    // Route::get('/context/search', [ContextController::class, 'search']); // TODO
    Route::post('/context/update', [ContextController::class, 'update']);
    Route::post('/system/sync', [ContextController::class, 'sync']);
});

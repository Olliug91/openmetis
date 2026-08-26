<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Dashboard;
use App\Livewire\Config;

Route::get('/login', function () {
    if (session('is_admin')) return redirect('/');
    return view('login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    if ($request->password === env('DASHBOARD_PASSWORD', 'admin')) {
        session(['is_admin' => true]);
        return redirect('/');
    }
    return back()->withErrors(['password' => 'Contraseña incorrecta']);
});

Route::get('/logout', function () {
    session()->forget('is_admin');
    return redirect('/login');
})->name('logout');

Route::middleware([\App\Http\Middleware\ProtectDashboard::class])->group(function () {
    Route::get('/', function () {
        $path = rtrim(config('app.brain_path', storage_path('app/cerebro')), '/');
        
        $fileCount = 0;
        $recentFiles = [];
        if (\Illuminate\Support\Facades\File::exists($path)) {
            $allFiles = \Illuminate\Support\Facades\File::allFiles($path);
            foreach ($allFiles as $f) {
                if (str_contains($f->getPathname(), '/.git/')) continue;
                $fileCount++;
                $recentFiles[] = [
                    'name' => $f->getRelativePathname(),
                    'time' => $f->getMTime()
                ];
            }
            // Sort by time descending
            usort($recentFiles, function($a, $b) { return $b['time'] <=> $a['time']; });
            $recentFiles = array_slice($recentFiles, 0, 5); // top 5
        }
        
        $gitLog = 'Sin historial git';
        if (\Illuminate\Support\Facades\File::exists($path . '/.git')) {
            $gitLog = shell_exec("cd {$path} && git log -1 --pretty=format:'%s (%cr)' 2>&1");
        }

        return view('dashboard', compact('fileCount', 'recentFiles', 'gitLog'));
    })->name('dashboard');
    
    Route::get('/docs', function () {
        return view('docs');
    })->name('docs');

    Route::get('/archivos', function () {
        $path = rtrim(config('app.brain_path', storage_path('app/cerebro')), '/');
        
        $files = [];
        if (\Illuminate\Support\Facades\File::exists($path)) {
            $allFiles = \Illuminate\Support\Facades\File::allFiles($path);
            foreach ($allFiles as $f) {
                if (str_contains($f->getPathname(), '/.git/')) continue;
                $files[] = [
                    'name' => $f->getRelativePathname(),
                    'size' => round($f->getSize() / 1024, 2) . ' KB',
                    'updated_at' => date('d/m/Y H:i:s', $f->getMTime()),
                ];
            }
        }
        
        $gitStatus = 'No es un repositorio git.';
        $gitLog = '';
        if (\Illuminate\Support\Facades\File::exists($path . '/.git')) {
            $gitStatus = shell_exec("cd {$path} && git status -s 2>&1") ?: 'Todo sincronizado (working tree clean)';
            $gitLog = shell_exec("cd {$path} && git log -1 --pretty=format:'%h - %s (%cr)' 2>&1");
        }

        return view('archivos', compact('files', 'gitStatus', 'gitLog', 'path'));
    })->name('archivos');

    Route::get('/archivos/ver', function (\Illuminate\Http\Request $request) {
        $path = rtrim(config('app.brain_path', storage_path('app/cerebro')), '/');
        $file = $request->query('file');
        
        if (!$file || str_contains($file, '../')) {
            return abort(404);
        }
        
        $fullPath = $path . '/' . ltrim($file, '/');
        
        if (!\Illuminate\Support\Facades\File::exists($fullPath) || is_dir($fullPath)) {
            return abort(404, 'Archivo no encontrado');
        }
        
        $content = file_get_contents($fullPath);
        
        return view('ver_archivo', compact('file', 'content'));
    })->name('archivos.ver');

    Route::get('/config', function () {
        return view('config');
    })->name('config');

    Route::post('/config', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'api_bearer_token' => 'required|string',
            'brain_path' => 'required|string',
            'dashboard_password' => 'required|string',
            'allowed_extensions' => 'required|string',
            'excluded_files' => 'nullable|string',
            'system_prompt' => 'required|string',
            'github_webhook_secret' => 'nullable|string',
            'github_pat' => 'nullable|string',
        ]);

        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        $updates = [
            'API_BEARER_TOKEN' => $request->api_bearer_token,
            'BRAIN_PATH' => rtrim($request->brain_path, '/'),
            'DASHBOARD_PASSWORD' => $request->dashboard_password,
            'BRAIN_ALLOWED_EXTENSIONS' => $request->allowed_extensions,
            'BRAIN_EXCLUDED_FILES' => $request->excluded_files ?? '',
            'SYSTEM_PROMPT' => str_replace(["\r", "\n"], ['\r', '\n'], $request->system_prompt),
            'GITHUB_WEBHOOK_SECRET' => $request->github_webhook_secret ?? '',
            'GITHUB_PAT' => $request->github_pat ?? '',
        ];

        foreach ($updates as $key => $val) {
            $val = '"' . trim($val) . '"';
            if (preg_match("/^{$key}=.*/m", $envContent)) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$val}", $envContent);
            } else {
                $envContent .= "\n{$key}={$val}";
            }
        }

        file_put_contents($envFile, $envContent);
        
        // Si cambia la contraseña y no coincide, cerramos sesión? Mejor no, ya se revalidará o no es necesario.
        // Pero si la cambia, actualizamos la password actual si quisieramos.
        // Por seguridad, si cambia la contraseña, cerramos sesión:
        if ($request->dashboard_password !== env('DASHBOARD_PASSWORD')) {
            session()->forget('is_admin');
            return redirect('/login')->with('status', 'Contraseña actualizada. Inicia sesión de nuevo.');
        }

        return back()->with('success', 'Configuración actualizada correctamente.');
    });

    Route::get('/download-template', function () {
        return response()->download(base_path('n8n_template.json'), 'OpenMetis_Agent.json');
    })->name('download.template');
});

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
        return view('dashboard');
    })->name('dashboard');

    Route::get('/config', function () {
        return view('config');
    })->name('config');

    Route::post('/config', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'api_bearer_token' => 'required|string',
            'brain_path' => 'required|string',
            'dashboard_password' => 'required|string',
        ]);

        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        $updates = [
            'API_BEARER_TOKEN' => $request->api_bearer_token,
            'BRAIN_PATH' => rtrim($request->brain_path, '/'),
            'DASHBOARD_PASSWORD' => $request->dashboard_password,
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

<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - OpenMetis AI</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="bg-zinc-950 h-screen flex items-center justify-center font-sans antialiased selection:bg-emerald-500/30 selection:text-emerald-200">
    <!-- Efecto de fondo (Grid) -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none opacity-20">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
    </div>

    <div class="z-10 bg-zinc-900/50 backdrop-blur-md rounded-2xl shadow-2xl shadow-black/50 border border-zinc-800/80 p-8 max-w-sm w-full relative overflow-hidden">
        <!-- Glow top -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-gradient-to-r from-emerald-400 to-cyan-500 rounded-b-full"></div>
        
        <div class="text-center mb-8 mt-2">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400/20 to-cyan-500/20 border border-emerald-500/30 shadow-lg shadow-emerald-500/10 mb-4">
                <svg class="w-8 h-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
            <h1 class="text-2xl font-bold text-zinc-100 tracking-wide">OpenMetis<span class="text-cyan-400">.AI</span></h1>
            <p class="text-zinc-500 text-sm mt-1 font-mono uppercase tracking-widest text-xs">Auth Required</p>
        </div>

        <form method="POST" action="/login" class="space-y-6">
            @csrf
            <div>
                <input type="password" name="password" 
                    class="w-full text-center text-xl tracking-[0.3em] font-mono bg-zinc-950/80 border border-zinc-800 text-zinc-300 px-4 py-3 rounded-xl focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all outline-none"
                    placeholder="••••••••" required autofocus>
                
                @if($errors->has("password"))
                    <p class="text-rose-400 text-sm mt-3 font-medium text-center bg-rose-500/10 py-2 rounded-lg border border-rose-500/20">{{ $errors->first("password") }}</p>
                @endif
                @if(session('status'))
                    <p class="text-emerald-400 text-sm mt-3 font-medium text-center bg-emerald-500/10 py-2 rounded-lg border border-emerald-500/20">{{ session('status') }}</p>
                @endif
            </div>

            <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-400 text-zinc-950 font-bold py-3.5 px-4 rounded-xl transition-all shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                INICIAR SISTEMA
            </button>
        </form>
    </div>
</body>
</html>

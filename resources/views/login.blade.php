<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - OpenMetis AI</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="bg-slate-900 h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-8 max-w-md w-full text-center">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">🧠 OpenMetis AI</h1>
        <p class="text-slate-500 mb-8">Introduce tu Contraseña Maestra</p>

        <form method="POST" action="/login">
            @csrf
            <div class="mb-6">
                <input type="password" name="password" 
                    class="w-full text-center text-lg px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-blue-500 focus:outline-none transition-colors"
                    placeholder="••••••••" required autofocus>
                
                @if($errors->has("password"))
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $errors->first("password") }}</p>
                @endif
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                Acceder al Panel
            </button>
        </form>
    </div>
</body>
</html>

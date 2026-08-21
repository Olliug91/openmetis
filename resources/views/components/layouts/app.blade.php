<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="bg-gray-100 text-gray-900 font-sans antialiased">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <div class="bg-slate-800 text-white w-64 flex-shrink-0">
                <div class="p-6">
                    <h1 class="text-2xl font-bold tracking-wider">🧠 OpenBrain</h1>
                    <p class="text-slate-400 text-sm mt-1">Cerebro API</p>
                </div>
                <nav class="mt-6">
                    <a href="/" class="block py-3 px-6 text-slate-200 hover:bg-slate-700 hover:text-white transition">Dashboard</a>
                    <a href="/config" class="block py-3 px-6 text-slate-200 hover:bg-slate-700 hover:text-white transition">Configuración</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    {{ $slot }}
                </div>
            </div>
        </div>

        @livewireScripts
    </body>
</html>

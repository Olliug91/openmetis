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
            <div class="bg-slate-800 text-white w-64 flex-shrink-0 flex flex-col justify-between">
                <div>
                    <div class="p-6">
                        <h1 class="text-2xl font-bold tracking-wider">🧠 OpenMetis</h1>
                        <p class="text-slate-400 text-sm mt-1">AI Assistant</p>
                    </div>
                    <nav class="mt-6">
                        <a href="/" class="block py-3 px-6 text-slate-200 hover:bg-slate-700 hover:text-white transition">Dashboard</a>
                        <a href="/archivos" class="block py-3 px-6 text-slate-200 hover:bg-slate-700 hover:text-white transition">Explorador de Archivos</a>
                        <a href="/config" class="block py-3 px-6 text-slate-200 hover:bg-slate-700 hover:text-white transition">Configuración</a>
                        <a href="/docs" class="block py-3 px-6 text-slate-200 hover:bg-slate-700 hover:text-white transition">Guía de Instalación</a>
                    </nav>
                </div>
                <div class="p-4">
                    <a href="/logout" class="block w-full text-center py-2 px-4 bg-slate-700 hover:bg-red-600 text-white rounded transition text-sm">
                        Cerrar Sesión
                    </a>
                </div>
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

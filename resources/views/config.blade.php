<x-layouts.app>
    <div>
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Configuración de OpenMetis AI</h2>

        @if (session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/config" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- PANEL: General -->
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-blue-500">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Ajustes Generales
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contraseña del Panel</label>
                            <input type="text" name="dashboard_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" value="{{ env('DASHBOARD_PASSWORD') }}" required>
                            <p class="text-xs text-gray-500 mt-1">Contraseña para acceder a esta interfaz web.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ruta del Cerebro (.md)</label>
                            <input type="text" name="brain_path" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" value="{{ config('app.brain_path') }}" required>
                            <p class="text-xs text-gray-500 mt-1">Ruta absoluta local de la carpeta de tu repositorio del cerebro.</p>
                        </div>
                    </div>
                </div>

                <!-- PANEL: API & Seguridad -->
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-red-500">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        API & Webhooks
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">API Bearer Token (n8n)</label>
                            <input type="text" name="api_bearer_token" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-red-500 focus:border-red-500 font-mono text-sm" value="{{ config('app.api_bearer_token') }}" required>
                            <p class="text-xs text-gray-500 mt-1">Token usado por n8n para autenticarse contra esta API.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">GitHub Webhook Secret (Opcional)</label>
                            <input type="text" name="github_webhook_secret" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-red-500 focus:border-red-500 font-mono text-sm" value="{{ config('openmetis.github_webhook_secret') }}">
                            <p class="text-xs text-gray-500 mt-1">Si configuras un webhook en Github hacia `/api/deploy`, pon aquí el secret.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL: Motor de Contexto -->
            <div class="bg-white rounded-lg shadow p-6 border-t-4 border-purple-500">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    Motor de Contexto & IA
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">System Prompt (Inyección Base)</label>
                        <textarea name="system_prompt" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-purple-500 focus:border-purple-500 font-mono text-sm" required>{{ str_replace(['\r', '\n'], ["\r", "\n"], config('openmetis.system_prompt')) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Las instrucciones maestras que se inyectan a la IA junto con tus archivos.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Extensiones Permitidas</label>
                            <input type="text" name="allowed_extensions" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-purple-500 focus:border-purple-500 font-mono text-sm" value="{{ config('openmetis.allowed_extensions') }}" placeholder="md, json, txt" required>
                            <p class="text-xs text-gray-500 mt-1">Separadas por comas. Solo estos archivos se leerán en el contexto.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lista Negra (Excluir archivos)</label>
                            <input type="text" name="excluded_files" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border focus:ring-purple-500 focus:border-purple-500 font-mono text-sm" value="{{ config('openmetis.excluded_files') }}" placeholder="ufc_, n8n_nexus_workflow.json">
                            <p class="text-xs text-gray-500 mt-1">Prefijos o nombres exactos de archivos para ignorar (ej: historicos muy pesados).</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-gray-800 hover:bg-black text-white font-bold py-3 px-6 rounded-lg transition shadow-md flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Guardar Configuración
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>

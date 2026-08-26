<x-layouts.app>
    <div>
        <h2 class="text-3xl font-bold mb-8 text-zinc-100 tracking-tight">System<span class="text-emerald-400">.Settings</span></h2>

        @if(session('success'))
            <div class="bg-emerald-500/10 border-l-4 border-emerald-500 text-emerald-400 p-4 mb-6 rounded-r-lg" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-500/10 border-l-4 border-rose-500 text-rose-400 p-4 mb-6 rounded-r-lg" role="alert">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div x-data="{ tab: 'general' }">
            <!-- Tabs -->
            <div class="flex border-b border-zinc-800/80 mb-6 space-x-1">
                <button @click="tab = 'general'" :class="tab === 'general' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-zinc-500 hover:text-zinc-300'" class="px-5 py-3 border-b-2 font-medium text-sm transition">
                    General
                </button>
                <button @click="tab = 'ia'" :class="tab === 'ia' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-zinc-500 hover:text-zinc-300'" class="px-5 py-3 border-b-2 font-medium text-sm transition">
                    Reglas de IA
                </button>
                <button @click="tab = 'github'" :class="tab === 'github' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-zinc-500 hover:text-zinc-300'" class="px-5 py-3 border-b-2 font-medium text-sm transition">
                    Sincronización Git
                </button>
                <button @click="tab = 'n8n'" :class="tab === 'n8n' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-zinc-500 hover:text-zinc-300'" class="px-5 py-3 border-b-2 font-medium text-sm transition">
                    Webhooks & n8n
                </button>
            </div>

            <form action="/config" method="POST" class="bg-zinc-900/40 rounded-xl shadow-xl shadow-black/20 border border-zinc-800/80 p-8">
                @csrf

                <!-- Tab General -->
                <div x-show="tab === 'general'" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Ruta Local del Cerebro</label>
                        <input type="text" name="brain_path" value="{{ env('BRAIN_PATH', storage_path('app/cerebro')) }}" class="w-full bg-zinc-950/50 border border-zinc-800 rounded-lg p-3 text-zinc-300 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition font-mono text-sm">
                        <p class="text-xs text-zinc-500 mt-2">Directorio absoluto donde se guardan tus notas Markdown.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Contraseña del Panel (Dashboard)</label>
                        <input type="text" name="dashboard_password" value="{{ env('DASHBOARD_PASSWORD') }}" class="w-full bg-zinc-950/50 border border-zinc-800 rounded-lg p-3 text-zinc-300 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition font-mono text-sm">
                    </div>
                </div>

                <!-- Tab IA -->
                <div x-show="tab === 'ia'" style="display: none;" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">System Prompt de la IA</label>
                        <textarea name="system_prompt" rows="5" class="w-full bg-zinc-950/50 border border-zinc-800 rounded-lg p-3 text-zinc-300 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition font-mono text-sm">{{ str_replace(['\r', '\n'], ["\r", "\n"], env('SYSTEM_PROMPT', 'Eres un asistente experto. Tus respuestas deben ser en formato Markdown.')) }}</textarea>
                        <p class="text-xs text-zinc-500 mt-2">Instrucciones base que se inyectan siempre a la IA antes de leer tus notas.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Extensiones Permitidas</label>
                        <input type="text" name="allowed_extensions" value="{{ env('BRAIN_ALLOWED_EXTENSIONS', 'md,txt') }}" class="w-full bg-zinc-950/50 border border-zinc-800 rounded-lg p-3 text-zinc-300 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition font-mono text-sm">
                        <p class="text-xs text-zinc-500 mt-2">Separadas por comas (ej: md,txt,csv). La IA solo podrá leer estos archivos.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Archivos/Carpetas Excluidos</label>
                        <input type="text" name="excluded_files" value="{{ env('BRAIN_EXCLUDED_FILES', 'scripts,perfil.md') }}" class="w-full bg-zinc-950/50 border border-zinc-800 rounded-lg p-3 text-zinc-300 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition font-mono text-sm">
                        <p class="text-xs text-zinc-500 mt-2">Separados por comas. Oculta estos archivos a la IA (útil para ocultar reglas internas o scripts).</p>
                    </div>
                </div>

                <!-- Tab Git -->
                <div x-show="tab === 'github'" style="display: none;" class="space-y-6">
                    <div class="bg-zinc-800/30 p-4 rounded-lg border border-zinc-800 mb-6">
                        <h4 class="text-sm font-semibold text-zinc-300 mb-1">Despliegue Automático</h4>
                        <p class="text-xs text-zinc-500">Configura estas variables para que el VPS pueda hacer `git push` a tu repositorio automáticamente tras cada modificación de la IA.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">GitHub Personal Access Token (PAT)</label>
                        <input type="password" name="github_pat" value="{{ env('GITHUB_PAT') }}" class="w-full bg-zinc-950/50 border border-zinc-800 rounded-lg p-3 text-zinc-300 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition font-mono text-sm">
                        <p class="text-xs text-zinc-500 mt-2">Token para hacer push vía HTTPS (ej: ghp_xxxxxxxxxxxxxxxxxxxx).</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Secreto Webhook (Incoming Git Pull)</label>
                        <input type="text" name="github_webhook_secret" value="{{ env('GITHUB_WEBHOOK_SECRET') }}" class="w-full bg-zinc-950/50 border border-zinc-800 rounded-lg p-3 text-zinc-300 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition font-mono text-sm">
                        <p class="text-xs text-zinc-500 mt-2">Contraseña opcional si configuras webhooks de GitHub hacia el endpoint `/api/deploy`.</p>
                    </div>
                </div>

                <!-- Tab n8n -->
                <div x-show="tab === 'n8n'" style="display: none;" class="space-y-6">
                    <div class="flex items-center justify-between bg-zinc-800/30 p-4 rounded-lg border border-zinc-800 mb-6">
                        <div>
                            <h4 class="text-sm font-semibold text-zinc-300 mb-1">Plantilla de Flujo para n8n</h4>
                            <p class="text-xs text-zinc-500">Descarga el JSON base para importar el agente inteligente completo a n8n.</p>
                        </div>
                        <a href="/download-template" class="bg-indigo-500/20 text-indigo-400 hover:bg-indigo-500 hover:text-white px-4 py-2 rounded-lg transition font-medium text-sm border border-indigo-500/50 hover:border-indigo-500 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            Descargar n8n Template
                        </a>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Bearer Token (Autenticación API)</label>
                        <div class="relative">
                            <input type="text" name="api_bearer_token" value="{{ env('API_BEARER_TOKEN') }}" class="w-full bg-zinc-950/50 border border-zinc-800 rounded-lg p-3 pl-10 text-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition font-mono text-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                        </div>
                        <p class="text-xs text-zinc-500 mt-2">La contraseña que usa n8n en las cabeceras HTTP para llamar a esta API.</p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-zinc-800/80 flex justify-end">
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-400 text-zinc-950 font-bold py-2.5 px-6 rounded-lg transition shadow-lg shadow-emerald-500/20 flex items-center">
                        <svg class="w-5 h-5 mr-2 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        Guardar Configuración
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

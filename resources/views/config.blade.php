<x-layouts.app>
    <div>
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Configuración del Sistema</h2>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Credenciales (APIs)</h3>
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/config" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">API Bearer Token (Local)</label>
                    <input type="text" name="api_bearer_token" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" value="{{ env('API_BEARER_TOKEN', config('app.api_bearer_token')) }}" required>
                    <p class="text-xs text-gray-500 mt-1">Este token lo usa n8n para autenticarse contra este panel.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ruta del Cerebro (.md)</label>
                    <input type="text" name="brain_path" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" value="{{ env('BRAIN_PATH', config('app.brain_path', '/Users/usuario/repo')) }}" required>
                    <p class="text-xs text-gray-500 mt-1">Ruta absoluta de la carpeta donde se leen y escriben tus notas.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contraseña Maestra (Panel Visual)</label>
                    <input type="text" name="dashboard_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" value="{{ env('DASHBOARD_PASSWORD') }}" required>
                    <p class="text-xs text-gray-500 mt-1">La contraseña que utilizas para acceder a esta web.</p>
                </div>
                
                <div class="pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition shadow-sm">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6 border-l-4 border-indigo-500">
            <h3 class="text-xl font-semibold mb-2 text-gray-700">🤖 Guía de Conexión: Telegram + n8n</h3>
            <p class="text-sm text-gray-600 mb-4">Sigue estos pasos exactos para conectar tu OpenMetis AI con el mundo exterior.</p>
            
            <ol class="list-decimal list-inside space-y-3 text-sm text-gray-700">
                <li>
                    <strong>Crea tu Bot de Telegram:</strong> Abre Telegram, busca al usuario <code class="bg-gray-100 px-1 py-0.5 rounded text-pink-600">@BotFather</code> y mándale el comando <code>/newbot</code>. 
                    Guarda el <strong>Bot Token</strong> que te devolverá al final.
                </li>
                <li>
                    <strong>Importa el Agente en n8n:</strong> En tu n8n, importa la plantilla preconfigurada para que tu Cerebro cobre vida.
                    <div class="mt-2 mb-1">
                        <a href="{{ route('download.template') }}" class="inline-flex items-center px-3 py-1.5 bg-pink-100 text-pink-700 hover:bg-pink-200 hover:text-pink-800 text-xs font-bold rounded shadow-sm transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Descargar n8n_template.json
                        </a>
                    </div>
                </li>
                <li>
                    <strong>Configura las Credenciales en n8n:</strong>
                    <ul class="list-disc list-inside ml-6 mt-1 space-y-1 text-gray-600">
                        <li>En el nodo de <em>Telegram Trigger</em>, crea una nueva credencial y pega tu Bot Token.</li>
                        <li>En el nodo de <em>Groq Whisper</em>, edita la cabecera <code>Authorization</code> y pon tu API Key de Groq (o usa el sistema de variables de entorno de n8n).</li>
                    </ul>
                </li>
                <li>
                    <strong>Vincula esta API a n8n:</strong> Todos los nodos HTTP (Obtener Contexto, Guardar Nota, etc.) hacen peticiones a este panel.
                    Asegúrate de que tus variables de entorno de n8n apunten aquí:
                    <div class="mt-2 bg-gray-800 text-green-400 p-3 rounded-md font-mono text-xs">
                        API_URL="{{ url('/') }}"<br>
                        API_BEARER_TOKEN="{{ config('app.api_bearer_token') }}"
                    </div>
                </li>
            </ol>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6 border-l-4 border-orange-500">
            <h3 class="text-xl font-semibold mb-2 text-gray-700">⚡ ¿Qué es Groq y por qué lo usamos?</h3>
            <p class="text-sm text-gray-600 mb-3">
                <strong>Groq</strong> es un proveedor de Inteligencia Artificial que procesa datos a una velocidad asombrosa. 
                En OpenMetis utilizamos su modelo <em>Whisper</em> para <strong>transcribir tus audios de Telegram a texto casi en tiempo real</strong> y sin coste.
            </p>
            <div class="bg-orange-50 rounded p-4 text-sm text-gray-800">
                <ol class="list-decimal list-inside space-y-2">
                    <li>Entra en <a href="https://console.groq.com" target="_blank" class="text-orange-600 font-bold hover:underline">console.groq.com</a> y regístrate gratis.</li>
                    <li>Ve a la sección <strong>API Keys</strong> y crea una nueva clave.</li>
                    <li>Pégala en n8n. Puedes hacerlo directamente en el nodo de <em>Groq Whisper</em> (en la cabecera <code>Authorization</code> poniendo <code>Bearer TU_CLAVE</code>), o usando la variable de entorno <code>GROQ_API_KEY</code>.</li>
                </ol>
            </div>
        </div>
    </div>
</x-layouts.app>

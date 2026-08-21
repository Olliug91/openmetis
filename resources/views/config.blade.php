<x-layouts.app>
    <div>
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Configuración del Sistema</h2>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Credenciales (APIs)</h3>
            
            <form action="#" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">API Bearer Token (Local)</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border bg-gray-50" value="{{ config('app.api_bearer_token') }}" readonly>
                    <p class="text-xs text-gray-500 mt-1">Este token lo usa n8n para autenticarse contra este panel. Puedes cambiarlo en tu archivo .env (API_BEARER_TOKEN).</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ruta del Repositorio Local</label>
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" value="{{ config('app.brain_path', '/Users/usuario/repo') }}">
                </div>
                
                <div class="pt-4">
                    <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                        Guardar Configuración
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
                    <strong>Importa el Agente en n8n:</strong> En tu n8n, importa el archivo <code class="bg-gray-100 px-1 py-0.5 rounded text-pink-600">n8n_template.json</code> que está en la raíz de este proyecto.
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
    </div>
</x-layouts.app>

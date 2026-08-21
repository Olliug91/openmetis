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
                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" value="/Users/guillo/Herd/cerebro-guillo" placeholder="Ej: /Users/usuario/repo">
                </div>
                
                <div class="pt-4">
                    <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                        Guardar Configuración
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

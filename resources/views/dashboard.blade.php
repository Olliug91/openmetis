<x-layouts.app>
    <div>
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Dashboard</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <h3 class="text-gray-500 text-sm font-semibold uppercase mb-1">Estado de Git</h3>
                <p class="text-2xl font-bold text-gray-800">Sincronizado</p>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <h3 class="text-gray-500 text-sm font-semibold uppercase mb-1">API Status</h3>
                <p class="text-2xl font-bold text-gray-800">Operativa</p>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                <h3 class="text-gray-500 text-sm font-semibold uppercase mb-1">Notas Procesadas</h3>
                <p class="text-2xl font-bold text-gray-800">14</p>
            </div>
        </div>
    </div>
</x-layouts.app>

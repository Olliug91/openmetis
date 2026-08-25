<x-layouts.app>
    <div>
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Explorador del Cerebro</h2>
        
        <div class="mb-6 bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500">
            <h3 class="text-gray-500 text-sm font-semibold uppercase mb-2">Información del Repositorio Git</h3>
            <p class="text-sm text-gray-700 mb-1"><strong>Ruta actual:</strong> {{ $path }}</p>
            <p class="text-sm text-gray-700 mb-1"><strong>Último Commit:</strong> {{ $gitLog ?: 'No disponible' }}</p>
            
            <div class="mt-3">
                <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Estado de archivos (Git Status):</p>
                <pre class="bg-gray-100 p-3 rounded text-sm text-gray-800 font-mono">{{ $gitStatus }}</pre>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Archivo
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tamaño
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Última Modificación
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($files as $file)
                    <tr>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <a href="/archivos/ver?file={{ urlencode($file['name']) }}" class="text-indigo-600 hover:text-indigo-900 hover:underline font-medium whitespace-no-wrap flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                {{ $file['name'] }}
                            </a>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $file['size'] }}</p>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $file['updated_at'] }}</p>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm text-right">
                            <a href="/archivos/ver?file={{ urlencode($file['name']) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded transition text-xs font-semibold">Ver contenido</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-5 py-4 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                            No se encontraron archivos en el directorio del cerebro.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>

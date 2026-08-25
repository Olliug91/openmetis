<x-layouts.app>
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                {{ $file }}
            </h2>
            <a href="/archivos" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded transition shadow-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
            <div class="bg-gray-50 border-b border-gray-200 px-4 py-2 flex items-center">
                <span class="text-xs text-gray-500 font-mono uppercase">Contenido del archivo</span>
            </div>
            <div class="p-6 overflow-x-auto">
                <pre class="text-sm font-mono text-gray-800 whitespace-pre-wrap leading-relaxed">{{ $content }}</pre>
            </div>
        </div>
    </div>
</x-layouts.app>

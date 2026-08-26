<x-layouts.app>
    <div>
        <h2 class="text-3xl font-bold mb-8 text-zinc-100 tracking-tight">Memory<span class="text-cyan-400">.Explorer</span></h2>
        
        <div class="mb-8 bg-zinc-900/50 backdrop-blur-sm rounded-xl p-6 border border-zinc-800/50">
            <div class="flex items-center gap-3 mb-4">
                <svg class="w-5 h-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                <h3 class="text-zinc-300 text-sm font-semibold uppercase tracking-wider">Git Status</h3>
            </div>
            
            <div class="space-y-3">
                <p class="text-sm text-zinc-400 font-mono"><span class="text-zinc-500 mr-2">PATH:</span> {{ $path }}</p>
                <p class="text-sm text-zinc-400 font-mono"><span class="text-zinc-500 mr-2">HEAD:</span> {{ $gitLog ?: 'No disponible' }}</p>
                
                <div class="mt-4 pt-4 border-t border-zinc-800/50">
                    <pre class="bg-zinc-950 p-4 rounded-lg border border-zinc-800/80 text-sm text-emerald-400/90 font-mono overflow-x-auto shadow-inner shadow-black/50">{{ $gitStatus }}</pre>
                </div>
            </div>
        </div>
        
        <div class="bg-zinc-900/30 rounded-xl border border-zinc-800/50 overflow-hidden shadow-xl shadow-black/20" x-data="{ search: '' }">
            <div class="p-4 bg-zinc-900/80 border-b border-zinc-800 flex justify-end">
                <div class="relative w-full sm:w-64">
                    <input type="text" x-model="search" placeholder="Buscar archivo..." class="w-full bg-zinc-950 border border-zinc-800 rounded-lg py-2 pl-10 pr-4 text-sm text-zinc-300 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition font-mono">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                </div>
            </div>
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-6 py-4 bg-zinc-900/80 border-b border-zinc-800 text-left text-xs font-semibold text-zinc-400 uppercase tracking-wider">
                            Archivo
                        </th>
                        <th class="px-6 py-4 bg-zinc-900/80 border-b border-zinc-800 text-left text-xs font-semibold text-zinc-400 uppercase tracking-wider">
                            Tamaño
                        </th>
                        <th class="px-6 py-4 bg-zinc-900/80 border-b border-zinc-800 text-left text-xs font-semibold text-zinc-400 uppercase tracking-wider">
                            Última Modificación
                        </th>
                        <th class="px-6 py-4 bg-zinc-900/80 border-b border-zinc-800 text-right text-xs font-semibold text-zinc-400 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/50">
                    @forelse ($files as $file)
                    <tr class="hover:bg-zinc-800/30 transition group" x-show="search === '' || '{{ strtolower($file['name']) }}'.includes(search.toLowerCase())">
                        <td class="px-6 py-4 text-sm">
                            <a href="/archivos/ver?file={{ urlencode($file['name']) }}" class="text-cyan-400 hover:text-cyan-300 font-mono whitespace-no-wrap flex items-center transition">
                                <svg class="w-4 h-4 mr-2 text-zinc-500 group-hover:text-cyan-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                {{ $file['name'] }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-zinc-400">
                            {{ $file['size'] }}
                        </td>
                        <td class="px-6 py-4 text-sm text-zinc-500 font-mono">
                            {{ $file['updated_at'] }}
                        </td>
                        <td class="px-6 py-4 text-sm text-right">
                            <a href="/archivos/ver?file={{ urlencode($file['name']) }}" class="inline-flex items-center gap-1.5 text-zinc-300 hover:text-cyan-400 bg-zinc-800/50 hover:bg-zinc-800 px-3 py-1.5 rounded-md transition text-xs font-medium border border-zinc-700 hover:border-cyan-500/50">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-sm text-center text-zinc-500 font-mono bg-zinc-900/30">
                            No files found in memory directory.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>

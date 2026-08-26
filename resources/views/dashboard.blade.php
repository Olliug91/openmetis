<x-layouts.app>
    <div>
        <h2 class="text-3xl font-bold mb-8 text-zinc-100 tracking-tight">System<span class="text-emerald-400">.Status</span></h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-zinc-900/50 backdrop-blur-sm rounded-xl p-6 border border-zinc-800/50 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                <h3 class="text-zinc-500 text-xs font-mono uppercase mb-2 tracking-wider">Último Commit</h3>
                <p class="text-lg font-medium text-zinc-200 line-clamp-2 leading-snug">{{ $gitLog }}</p>
            </div>
            
            <div class="bg-zinc-900/50 backdrop-blur-sm rounded-xl p-6 border border-zinc-800/50 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/10 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                <h3 class="text-zinc-500 text-xs font-mono uppercase mb-2 tracking-wider">API Status (n8n Webhook)</h3>
                <div class="flex items-center gap-2">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <p class="text-2xl font-bold text-zinc-100">Operativa</p>
                </div>
            </div>
            
            <div class="bg-zinc-900/50 backdrop-blur-sm rounded-xl p-6 border border-zinc-800/50 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                <h3 class="text-zinc-500 text-xs font-mono uppercase mb-2 tracking-wider">Archivos Procesados</h3>
                <p class="text-4xl font-light text-zinc-100">{{ $fileCount }}<span class="text-zinc-600 text-lg ml-2 font-normal">notas</span></p>
            </div>
        </div>

        <div class="bg-zinc-900/30 rounded-xl border border-zinc-800/50 overflow-hidden">
            <div class="p-4 border-b border-zinc-800/50 bg-zinc-900/50">
                <h3 class="text-sm font-semibold text-zinc-300">Actividad Reciente (Últimos archivos)</h3>
            </div>
            <div class="divide-y divide-zinc-800/50">
                @foreach($recentFiles as $f)
                    <div class="p-4 flex justify-between items-center hover:bg-zinc-800/30 transition">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            <span class="text-zinc-300 font-mono text-sm">{{ $f['name'] }}</span>
                        </div>
                        <span class="text-zinc-500 text-xs">{{ date('d/m/Y H:i:s', $f['time']) }}</span>
                    </div>
                @endforeach
                @if(empty($recentFiles))
                    <div class="p-8 text-center text-zinc-500 text-sm">No hay archivos en la memoria todavía.</div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>

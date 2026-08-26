<x-layouts.app>
    <div>
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 mb-8">
            <div>
                <a href="/archivos" class="inline-flex items-center text-sm font-medium text-zinc-500 hover:text-cyan-400 transition mb-3">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Memory
                </a>
                <h2 class="text-2xl font-bold text-zinc-100 flex items-center tracking-tight font-mono">
                    <span class="text-cyan-400 mr-2">/</span>
                    {{ $file }}
                </h2>
            </div>
        </div>
        
        <div class="bg-zinc-900/50 backdrop-blur-sm rounded-xl shadow-2xl shadow-black/40 overflow-hidden border border-zinc-800/80">
            <div class="bg-zinc-950/80 border-b border-zinc-800 px-4 py-3 flex items-center justify-between">
                <div class="flex space-x-2">
                    <div class="w-3 h-3 rounded-full bg-rose-500/80"></div>
                    <div class="w-3 h-3 rounded-full bg-amber-500/80"></div>
                    <div class="w-3 h-3 rounded-full bg-emerald-500/80"></div>
                </div>
                <span class="text-xs text-zinc-500 font-mono tracking-widest uppercase opacity-50">Raw Output</span>
            </div>
            <div class="p-6 overflow-x-auto bg-zinc-900/80">
                <pre class="text-sm font-mono text-zinc-300 whitespace-pre-wrap leading-relaxed">{{ $content }}</pre>
            </div>
        </div>
    </div>
</x-layouts.app>

<x-layouts.app title="Guía de Instalación y Uso">
    <div class="max-w-4xl mx-auto space-y-8">
        <h1 class="text-3xl font-bold text-zinc-100 tracking-tight">System<span class="text-cyan-400">.Docs</span></h1>

        <div class="bg-zinc-900/50 backdrop-blur-sm rounded-xl border border-zinc-800/80 overflow-hidden shadow-2xl shadow-black/20">
            <div class="p-6 md:p-8 space-y-4">
                <h2 class="text-xl font-semibold text-zinc-200 border-b border-zinc-800/80 pb-3 flex items-center">
                    <span class="text-cyan-400 mr-3 font-mono">01.</span>
                    La Arquitectura (El Triángulo)
                </h2>
                <p class="text-zinc-400 text-sm leading-relaxed">OpenMetis funciona conectando tres piezas clave para que tus datos fluyan automáticamente:</p>
                <ul class="list-disc pl-5 text-zinc-400 text-sm space-y-2 mt-2">
                    <li><strong class="text-zinc-300">Tu Mac / PC (Local):</strong> Donde tienes los archivos Markdown de tu cerebro. Aquí usas tu IDE y tu asistente de IA local para programar y editar.</li>
                    <li><strong class="text-zinc-300">GitHub (Transporte):</strong> Un repositorio privado que hace de puente entre tu ordenador y el servidor.</li>
                    <li><strong class="text-zinc-300">El Servidor (VPS):</strong> Donde está instalada esta API y n8n. El bot de Telegram escribe aquí y la API se encarga de enviarlo a GitHub.</li>
                </ul>
            </div>
        </div>

        <div class="bg-zinc-900/50 backdrop-blur-sm rounded-xl border border-zinc-800/80 overflow-hidden shadow-2xl shadow-black/20">
            <div class="p-6 md:p-8 space-y-4">
                <h2 class="text-xl font-semibold text-zinc-200 border-b border-zinc-800/80 pb-3 flex items-center">
                    <span class="text-cyan-400 mr-3 font-mono">02.</span>
                    Configurar el Cerebro Local
                </h2>
                <ol class="list-decimal pl-5 text-zinc-400 text-sm space-y-3 mt-2">
                    <li>Copia la carpeta <code class="bg-zinc-950 text-emerald-400 px-1.5 py-0.5 rounded font-mono text-xs">brain-template/</code> de este proyecto a un lugar seguro en tu disco duro (ej: <code class="bg-zinc-950 text-emerald-400 px-1.5 py-0.5 rounded font-mono text-xs">~/cerebro-personal</code>).</li>
                    <li>Crea un repositorio privado en GitHub y sube esa carpeta (push inicial).</li>
                    <li>Abre esa carpeta en tu editor de código (Cursor, VSCode) y dile a tu agente de IA que lea el archivo <code class="bg-zinc-950 text-emerald-400 px-1.5 py-0.5 rounded font-mono text-xs">perfil.md</code> para que conozca las reglas de sincronización.</li>
                </ol>
            </div>
        </div>

        <div class="bg-zinc-900/50 backdrop-blur-sm rounded-xl border border-zinc-800/80 overflow-hidden shadow-2xl shadow-black/20">
            <div class="p-6 md:p-8 space-y-4">
                <h2 class="text-xl font-semibold text-zinc-200 border-b border-zinc-800/80 pb-3 flex items-center">
                    <span class="text-cyan-400 mr-3 font-mono">03.</span>
                    Configurar el Servidor y la API
                </h2>
                <ol class="list-decimal pl-5 text-zinc-400 text-sm space-y-3 mt-2">
                    <li>Entra a tu servidor (VPS) mediante SSH.</li>
                    <li>Clona tu repositorio del cerebro en una carpeta hermana a OpenMetis (ej: <code class="bg-zinc-950 text-emerald-400 px-1.5 py-0.5 rounded font-mono text-xs">/var/www/cerebro-personal</code>).</li>
                    <li>Ejecuta el instalador mágico: <code class="bg-zinc-950 text-emerald-400 px-1.5 py-0.5 rounded font-mono text-xs">php artisan openmetis:install</code>.</li>
                    <li>El instalador te pedirá la ruta de esa carpeta y te preguntará por tu <strong class="text-emerald-400">GitHub PAT</strong> (Personal Access Token). Ponlo para que la API pueda hacer push automáticamente.</li>
                </ol>
            </div>
        </div>

        <div class="bg-zinc-900/50 backdrop-blur-sm rounded-xl border border-zinc-800/80 overflow-hidden shadow-2xl shadow-black/20">
            <div class="p-6 md:p-8 space-y-4">
                <h2 class="text-xl font-semibold text-zinc-200 border-b border-zinc-800/80 pb-3 flex items-center">
                    <span class="text-cyan-400 mr-3 font-mono">04.</span>
                    Conectar la IA (n8n + Telegram + Groq)
                </h2>
                <ol class="list-decimal pl-5 text-zinc-400 text-sm space-y-4 mt-2">
                    <li>En el menú de "Configuración" de este panel, descarga la plantilla de n8n usando el botón.</li>
                    <li>Abre tu instancia de n8n, crea un Workflow nuevo e importa el archivo JSON.</li>
                    <li><strong class="text-zinc-300">Telegram:</strong> Ve a Telegram, busca a <code class="bg-zinc-950 text-emerald-400 px-1.5 py-0.5 rounded font-mono text-xs">@BotFather</code>, crea un bot nuevo y copia el HTTP API Token. Pégalo en el nodo azul de n8n (el Trigger).</li>
                    <li><strong class="text-zinc-300">Groq (El Motor de IA):</strong>
                        <ul class="list-disc pl-5 mt-2 text-zinc-500 space-y-2">
                            <li>Ve a <a href="https://console.groq.com/keys" target="_blank" class="text-cyan-400 hover:text-cyan-300 underline transition">console.groq.com</a> y créate una cuenta gratuita.</li>
                            <li>Genera una nueva <strong class="text-zinc-300">API Key</strong> y cópiala.</li>
                            <li>En n8n, abre el nodo verde (Groq Chat Model) y en <em>Credentials</em> añade una nueva credencial pegando tu clave.</li>
                            <li>Asegúrate de tener seleccionado un modelo rápido y capaz en el nodo (ej: <code class="bg-zinc-950 text-emerald-400 px-1.5 py-0.5 rounded font-mono text-xs">llama-3.1-70b-versatile</code>).</li>
                            <li><span class="text-amber-400/80">Nota:</span> El nodo de reconocimiento de voz (Whisper) también usa la misma API Key de Groq para transcribir tus audios a texto en milisegundos.</li>
                        </ul>
                    </li>
                    <li>Activa el Workflow (ponlo en ON) en la esquina superior derecha de n8n. ¡Ya puedes hablar con tu cerebro por Telegram!</li>
                </ol>
            </div>
        </div>
    </div>
</x-layouts.app>

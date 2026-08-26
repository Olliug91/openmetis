<x-layouts.app title="Guía de Instalación y Uso">
    <div class="max-w-4xl mx-auto space-y-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">🧠 Guía de Instalación y Uso de OpenMetis AI</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
            <div class="p-6 space-y-4">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">1. La Arquitectura (El Triángulo)</h2>
                <p class="text-gray-600">OpenMetis funciona conectando tres piezas clave para que tus datos fluyan automáticamente:</p>
                <ul class="list-disc pl-5 text-gray-600 space-y-2">
                    <li><strong>Tu Mac / PC (Local):</strong> Donde tienes los archivos Markdown de tu cerebro. Aquí usas tu IDE y tu asistente de IA local para programar y editar.</li>
                    <li><strong>GitHub (Transporte):</strong> Un repositorio privado que hace de puente entre tu ordenador y el servidor.</li>
                    <li><strong>El Servidor (VPS):</strong> Donde está instalada esta API y n8n. El bot de Telegram escribe aquí y la API se encarga de enviarlo a GitHub.</li>
                </ul>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
            <div class="p-6 space-y-4">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">2. Configurar el Cerebro Local</h2>
                <ol class="list-decimal pl-5 text-gray-600 space-y-2">
                    <li>Copia la carpeta <code>brain-template/</code> de este proyecto a un lugar seguro en tu disco duro (ej: <code>~/cerebro-personal</code>).</li>
                    <li>Crea un repositorio privado en GitHub y sube esa carpeta (push inicial).</li>
                    <li>Abre esa carpeta en tu editor de código (Cursor, VSCode) y dile a tu agente de IA que lea el archivo <code>perfil.md</code> para que conozca las reglas de sincronización.</li>
                </ol>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
            <div class="p-6 space-y-4">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">3. Configurar el Servidor y la API</h2>
                <ol class="list-decimal pl-5 text-gray-600 space-y-2">
                    <li>Entra a tu servidor (VPS) mediante SSH.</li>
                    <li>Clona tu repositorio del cerebro en una carpeta hermana a OpenMetis (ej: <code>/var/www/cerebro-personal</code>).</li>
                    <li>Ejecuta el instalador mágico: <code>php artisan openmetis:install</code>.</li>
                    <li>El instalador te pedirá la ruta de esa carpeta y te preguntará por tu <strong>GitHub PAT</strong> (Personal Access Token). Ponlo para que la API pueda hacer <code>git push</code> automáticamente sin pedirte contraseñas.</li>
                </ol>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
            <div class="p-6 space-y-4">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">4. Conectar la IA (n8n + Telegram)</h2>
                <ol class="list-decimal pl-5 text-gray-600 space-y-2">
                    <li>En el menú de "API & Webhooks" de este panel, descarga la plantilla de n8n.</li>
                    <li>Importa el archivo JSON en tu instancia de n8n.</li>
                    <li>Ve a Telegram, busca a <code>@BotFather</code>, crea un bot nuevo y copia el HTTP API Token. Pégalo en el nodo azul de n8n.</li>
                    <li>Abre el nodo verde (Groq) en n8n y ponle tu API Key de Groq (o usa el modelo de OpenAI si lo prefieres).</li>
                    <li>Activa el Workflow en n8n. ¡Ya puedes hablar con tu cerebro desde Telegram!</li>
                </ol>
            </div>
        </div>
    </div>
</x-layouts.app>

# 🧠 OpenBrain (Cerebro API)

Un ecosistema Open Source para construir tu propio "Cerebro Personal" (memoria y gestión de tareas). Integra transcripción de voz ultrarrápida (vía Telegram + Groq), inyección de contexto dinámico (vía esta API en Laravel) y ejecución de acciones mediante IA (agentes de n8n).

## 🚀 Características
- **Panel de Control UI:** Configura fácilmente tus credenciales de API, rutas locales y estado de Git mediante una interfaz limpia hecha con Livewire 3 y TailwindCSS.
- **Autocontrolado:** Tus datos se guardan en archivos Markdown locales. Tú eres dueño de tu privacidad. Sin costosas suscripciones mensuales de bases de datos vectoriales.
- **Microservicio API:** Permite a n8n leer el contexto, crear/actualizar notas y disparar sincronizaciones con GitHub.
- **Basado en SQLite:** No hace falta configurar MariaDB ni MySQL. Clona y ejecuta al instante.

## 🛠️ Instalación rápida

1. Clona el repositorio:
   ```bash
   git clone https://github.com/tu-usuario/cerebro-api.git
   cd cerebro-api
   ```
2. Instala las dependencias y prepara el entorno:
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   touch database/database.sqlite
   php artisan migrate
   ```
3. Levanta el servidor (o usa [Laravel Herd](https://herd.laravel.com/)):
   ```bash
   php artisan serve
   ```
4. Entra al Panel de Control (ej. `http://localhost:8000`) y ajusta tu token de API y la ruta local de tu carpeta de cerebro (archivos Markdown).

## 🤖 Integración con n8n
En la raíz de este proyecto encontrarás el archivo `n8n_template.json`. Impórtalo en tu instancia de n8n.
Ese Workflow ya está preparado para:
- Recibir notas de voz desde Telegram.
- Transcribir con Groq Whisper.
- Leer tu contexto personal a través de los endpoints de Laravel.
- **[NUEVO]** Usar Tools para guardar notas o ideas (llama a `/api/context/update`).
- **[NUEVO]** Sincronizar automáticamente hacia GitHub (llama a `/api/system/sync`).

Recuerda configurar en n8n las variables de entorno `API_URL` (la URL de este proyecto Laravel) y `API_BEARER_TOKEN` (el token que definas en tu panel de control).

## 📜 Licencia
Open Source - MIT. ¡Úsalo y modifícalo como quieras!

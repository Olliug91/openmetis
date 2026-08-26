# 🧠 OpenMetis AI

**Tu Segundo Cerebro Autónomo.**  
OpenMetis es un ecosistema open-source diseñado para convertir una simple carpeta de notas (Markdown) en un asistente de inteligencia artificial proactivo, accesible desde cualquier lugar (Telegram) y 100% bajo tu control.

Adiós a las suscripciones de bases de datos vectoriales complejas. OpenMetis conecta **tu Mac/PC**, **GitHub** y un **Servidor (VPS)** usando **n8n** y **Groq** para ofrecerte una memoria instantánea, edición de código mediante IA y transcripción de voz ultrarrápida.

---

## ✨ Características Principales

- 🌑 **Dashboard Hacker:** Interfaz moderna (Dark Mode) construida con Laravel Livewire 3 y TailwindCSS. Visualiza tus notas, estadísticas del sistema y ajusta las reglas de tu IA en tiempo real.
- ⚡ **Velocidad Groq:** Usa modelos ultra-rápidos (Llama 3.1) y reconocimiento de voz (Whisper) para hablarle a tu cerebro de forma natural y sin esperas.
- 🔄 **Auto-Sincronización Git:** Modifica tus notas en local usando tu IDE (como Cursor o VSCode), y cualquier cambio que hagas a través de Telegram se sincronizará automáticamente sin conflictos gracias al soporte de *GitHub Personal Access Tokens (PAT)*.
- 🤖 **Plantilla n8n Lista Para Usar:** Incluye el workflow `n8n_template.json` con toda la lógica de Agentes Inteligentes, memoria y llamadas a la API preconfiguradas.
- 🛠️ **Cerebro Starter Kit:** Al instalar, OpenMetis puede generarte una carpeta `brain-template/` con la estructura ideal (`perfil.md`, `tareas.md`, y scripts de sincronización) para empezar en segundos.

---

## 🏗️ La Arquitectura (El Triángulo)

1. **Tu Ordenador (Local):** Aquí es donde viven físicamente tus archivos Markdown. Programas, editas tus notas, y usas tu asistente local de IA.
2. **GitHub:** Actúa como el puente (transporte) privado y seguro.
3. **El Servidor (OpenMetis API + n8n):** Donde se ejecuta este código. n8n escucha tu Telegram, usa la IA para decidir qué hacer, y la API de OpenMetis se encarga de leer, escribir y enviar tus cambios a GitHub.

---

## 🚀 Instalación en 3 Pasos

### 1. Despliegue del Servidor (VPS)
Clona el repositorio en tu servidor (puedes usar Laravel Forge, Plesk, o directamente en tu directorio web):
```bash
git clone https://github.com/Olliug91/openmetis.git
cd openmetis
composer install
npm install && npm run build
```

### 2. El Instalador Mágico
Ejecuta el asistente interactivo de instalación. Éste configurará tu base de datos SQLite y te guiará para crear tu token de seguridad y tu primera carpeta de memoria:
```bash
php artisan openmetis:install
```

### 3. Conectar la IA
1. Entra a tu panel web (ej. `https://tu-dominio.com`).
2. Ve a la pestaña **Documentación** o **Configuración** y descarga la plantilla de n8n.
3. Importa el archivo JSON en tu n8n, añade el Token de tu bot de Telegram y tu API Key de Groq.
4. **¡Listo!** Escríbele o mándale un audio a tu bot.

---

## 🔒 Privacidad y Control
Toda tu memoria es texto plano (Markdown). No hay bases de datos opacas ni servicios de terceros espiando tus datos de conocimiento. La conexión API está protegida por un **Bearer Token** personal, y el panel web por una contraseña maestra.

## 🤝 Contribuir
OpenMetis está en constante evolución. Siéntete libre de abrir un Issue o un Pull Request con tus ideas.

## 📜 Licencia
Open Source - MIT.

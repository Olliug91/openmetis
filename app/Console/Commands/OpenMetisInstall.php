<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use function Laravel\Prompts\text;
use function Laravel\Prompts\info;
use function Laravel\Prompts\note;
use function Laravel\Prompts\confirm;

class OpenMetisInstall extends Command
{
    protected $signature = 'openmetis:install';
    protected $description = 'Instalador interactivo del ecosistema OpenMetis AI';

    public function handle()
    {
        info('🧠 Bienvenido al instalador de OpenMetis AI');

        // 1. Verificar y copiar .env
        if (!file_exists(base_path('.env'))) {
            note('Creando archivo .env desde .env.example...');
            copy(base_path('.env.example'), base_path('.env'));
            $this->callQuietly('key:generate');
        }

        // 2. Configurar Variables interactivamente
        $envContent = file_get_contents(base_path('.env'));

        $token = text(
            label: 'Define un Token de seguridad para la API (n8n usará este token)',
            placeholder: 'Ej: mi-token-super-secreto',
            default: Str::random(32),
            required: true
        );

        $this->line("");
        $this->line("<options=bold>📁 Configuración del Cerebro (Repositorio de Markdown)</>");
        $this->line("Para mantener tu código y tus datos separados, OpenMetis AI necesita leer y escribir en");
        $this->line("una carpeta externa. Lo ideal es que esta carpeta sea un repositorio Git (ej: clonado de Github).");
        $this->line("Te recomendamos tenerlos como carpetas 'hermanas' en tu servidor:");
        $this->line("  - /var/www/openmetis (Este proyecto)");
        $this->line("  - /var/www/mi-cerebro-repo (Tus notas Markdown)");
        $this->line("");

        $brainPath = text(
            label: '¿En qué ruta absoluta de este servidor está (o estará) la carpeta de tus notas?',
            placeholder: '/var/www/vhosts/tu-dominio/cerebro-personal',
            default: storage_path('app/brain'),
            required: true
        );

        $password = text(
            label: 'Define una Contraseña Maestra para entrar al Panel Visual',
            placeholder: 'Ej: 1234, admin, etc.',
            required: true
        );
        
        if (!file_exists($brainPath)) {
            if (confirm('La carpeta no existe. ¿Quieres que la cree por ti?', default: true)) {
                mkdir($brainPath, 0755, true);
                note('Carpeta creada: ' . $brainPath);
            }
        }

        // Reemplazar o añadir en el .env
        $envContent = preg_replace('/^API_BEARER_TOKEN=.*$/m', 'API_BEARER_TOKEN="' . $token . '"', $envContent);
        $envContent = preg_replace('/^BRAIN_PATH=.*$/m', 'BRAIN_PATH="' . $brainPath . '"', $envContent);
        
        if (str_contains($envContent, 'DASHBOARD_PASSWORD=')) {
            $envContent = preg_replace('/^DASHBOARD_PASSWORD=.*$/m', 'DASHBOARD_PASSWORD="' . $password . '"', $envContent);
        } else {
            $envContent .= "\nDASHBOARD_PASSWORD=\"$password\"";
        }
        
        file_put_contents(base_path('.env'), $envContent);

        // 3. Crear SQLite si no existe
        $dbPath = database_path('database.sqlite');
        if (!file_exists($dbPath)) {
            touch($dbPath);
        }

        // 4. Ejecutar migraciones
        note('Preparando la base de datos...');
        $this->callQuietly('migrate', ['--force' => true]);

        // 5. Limpiar cachés
        note('Optimizando aplicación...');
        $this->callQuietly('optimize:clear');

        info('✅ ¡OpenMetis AI se ha instalado y configurado con éxito!');

        note('Pasos siguientes para conectar tu IA (n8n y Telegram):');
        $this->line("1. Importa el archivo <fg=cyan>n8n_template.json</> en tu n8n.");
        $this->line("2. En n8n, usa este API Token que acabas de configurar: <fg=green>$token</>");
        $this->line("3. Crea un bot en Telegram hablando con <fg=yellow>@BotFather</> y pon sus credenciales en el nodo de Telegram en n8n.");
        
        if (!file_exists(public_path('build'))) {
            $this->line("\n⚠️ <fg=yellow>Nota:</> Falta compilar el panel visual. Ejecuta <fg=cyan>npm install && npm run build</> si no lo has hecho.");
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OpenMetisInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openmetis:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instalador automático del ecosistema OpenMetis AI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧠 Iniciando instalador de OpenMetis AI...');

        // 1. Verificar y copiar .env
        if (!file_exists(base_path('.env'))) {
            $this->warn('No se encontró archivo .env. Copiando .env.example...');
            copy(base_path('.env.example'), base_path('.env'));
            $this->call('key:generate');
            $this->info('.env configurado correctamente.');
        }

        // 2. Crear SQLite si no existe
        $dbPath = database_path('database.sqlite');
        if (!file_exists($dbPath)) {
            $this->warn('Base de datos no encontrada. Creando base de datos SQLite...');
            touch($dbPath);
        }

        // 3. Ejecutar migraciones
        $this->info('Ejecutando migraciones de base de datos...');
        $this->call('migrate', ['--force' => true]);

        // 4. Limpiar cachés
        $this->info('Limpiando y optimizando cachés...');
        $this->call('optimize:clear');

        // 5. Advertencia sobre assets (NPM)
        $this->info('🎨 Las dependencias de base de datos y backend están listas.');
        if (!file_exists(public_path('build'))) {
            $this->warn('Parece que los assets frontend (Tailwind/Livewire) no están compilados.');
            $this->line('Por favor, asegúrate de ejecutar:');
            $this->line('  <fg=yellow>npm install && npm run build</>');
        }

        $this->info("\n✅ ¡OpenMetis AI se ha instalado con éxito! Ya puedes acceder a tu panel.");
    }
}

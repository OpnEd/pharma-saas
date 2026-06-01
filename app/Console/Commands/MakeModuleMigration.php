<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * La firma del comando. Exige nombre, contexto y módulo.
 */
#[Signature('make:module:migration {name : El nombre de la migración (ej. create_batches_table)} {context : El Bounded Context (ej. Erp)} {module : El Módulo (ej. Inventory)}')]

#[Description('Crea una nueva migración dentro de la estructura DDD del módulo especificado')]

class MakeModuleMigration extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = Str::snake($this->argument('name'));
        $context = Str::studly($this->argument('context'));
        $module = Str::studly($this->argument('module'));

        $directoryPath = base_path("src/{$context}/{$module}/Infrastructure/Persistence/Migrations");

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        $timestamp = date('Y_m_d_His');
        $filename = "{$timestamp}_{$name}.php";
        $filepath = $directoryPath . '/' . $filename;

        $tableName = str_replace(['create_', '_table'], '', $name);

        // 1. Obtener el contenido del stub
        $content = $this->getMigrationStub($tableName);

        // 2. BLINDAJE CONTRA EL BOM (Elimina caracteres invisibles de codificación si existieran)
        $bom = pack('H*', 'EFBBBF');
        $content = preg_replace("/^$bom/", '', $content);

        // 3. BLINDAJE CONTRA ESPACIOS ANTES DE <?php
        // ltrim elimina saltos de línea y espacios accidentales al puro inicio del archivo
        $content = ltrim($content);

        File::put($filepath, $content);

        $this->info("Migración creada exitosamente en:");
        $this->line("<fg=green>{$filepath}</>");
    }

    /**
     * Plantilla base para la migración.
     */
    protected function getMigrationStub(string $tableName): string
    {
        // Al pegar esto, asegúrate de que "<?php" no tenga espacios a su izquierda.
        return "<?php

            use Illuminate\Database\Migrations\Migration;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Support\Facades\Schema;
            
            return new class extends Migration
            {
                /**
                 * Run the migrations.
                 */
                public function up(): void
                {
                    Schema::create('{$tableName}', function (Blueprint \$table) {
                        \$table->id();
                        
                        // \$table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
                        
                        \$table->timestamps();
                    });
                }
            
                /**
                 * Reverse the migrations.
                 */
                public function down(): void
                {
                    Schema::dropIfExists('{$tableName}');
                }
            };
        ";
    }
}

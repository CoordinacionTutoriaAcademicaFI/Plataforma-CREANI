<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Quitar NOT NULL para permitir valores nulos al inicio
        DB::statement('ALTER TABLE attempts ALTER COLUMN inicio_at DROP NOT NULL');
        DB::statement('ALTER TABLE attempts ALTER COLUMN fin_at DROP NOT NULL');
        DB::statement('ALTER TABLE attempts ALTER COLUMN detalle_por_seccion_json DROP NOT NULL');
    }

    public function down(): void
    {
        // Si haces rollback, vuelves a ponerlas como NOT NULL
        DB::statement('ALTER TABLE attempts ALTER COLUMN inicio_at SET NOT NULL');
        DB::statement('ALTER TABLE attempts ALTER COLUMN fin_at SET NOT NULL');
        DB::statement('ALTER TABLE attempts ALTER COLUMN detalle_por_seccion_json SET NOT NULL');
    }
};

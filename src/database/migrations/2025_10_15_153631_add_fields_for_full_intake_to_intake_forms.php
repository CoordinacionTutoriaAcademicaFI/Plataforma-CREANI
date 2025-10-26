<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('intake_forms', function (Blueprint $table) {
            // Q20: repetir correo
            if (!Schema::hasColumn('intake_forms', 'email_contacto_confirm')) {
                $table->string('email_contacto_confirm', 180)->nullable()->after('email_contacto');
            }

            // Q12: convivencias (multi) + "otro"
            if (!Schema::hasColumn('intake_forms', 'convivencias')) {
                $table->jsonb('convivencias')->nullable()->after('equipo_computo');
            }
            if (!Schema::hasColumn('intake_forms', 'convivencia_otro')) {
                $table->string('convivencia_otro', 255)->nullable()->after('convivencias');
            }

            // Q18/Q19: “otro”
            if (!Schema::hasColumn('intake_forms', 'plataformas_otro')) {
                $table->string('plataformas_otro', 255)->nullable()->after('plataformas_usadas');
            }
            if (!Schema::hasColumn('intake_forms', 'medios_otro')) {
                $table->string('medios_otro', 255)->nullable()->after('medios_comunicacion');
            }
        });

        // (Opcional) Migrar valores existentes de 'convivencia' -> 'convivencias'
        if (Schema::hasColumn('intake_forms', 'convivencia')) {
            DB::statement("UPDATE intake_forms SET convivencias = CASE
                WHEN convivencia IS NULL OR convivencia = '' THEN '[]'::jsonb
                ELSE jsonb_build_array(convivencia) END
            WHERE convivencias IS NULL");
        }
    }

    public function down(): void
    {
        Schema::table('intake_forms', function (Blueprint $table) {
            if (Schema::hasColumn('intake_forms', 'medios_otro')) $table->dropColumn('medios_otro');
            if (Schema::hasColumn('intake_forms', 'plataformas_otro')) $table->dropColumn('plataformas_otro');
            if (Schema::hasColumn('intake_forms', 'convivencia_otro')) $table->dropColumn('convivencia_otro');
            if (Schema::hasColumn('intake_forms', 'convivencias')) $table->dropColumn('convivencias');
            if (Schema::hasColumn('intake_forms', 'email_contacto_confirm')) $table->dropColumn('email_contacto_confirm');
        });
    }
};

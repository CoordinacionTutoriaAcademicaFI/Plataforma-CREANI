<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('intake_forms', function (Blueprint $table) {
            $table->id();

            // 1 alumno == 1 formulario
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unique('user_id');

            // Datos de contacto / control
            $table->string('email_contacto', 180)->index();   // puede venir de users.email
            $table->string('ingenieria', 120);                // civil|mecanica|computacion|electronica|sistemas|ia

            // Académicos de ingreso
            $table->decimal('promedio_bachillerato', 4, 2)->nullable(); // p.ej. 9.30
            $table->decimal('indice_uaem', 7, 3)->nullable();           // si lleva decimales; flexible
            $table->unsignedInteger('lugar_examen')->nullable();
            $table->string('numero_folio', 32)->nullable();
            $table->string('numero_cuenta', 16)->nullable();            // 7 dígitos si aplica

            // Redes / contacto
            $table->text('facebook_url')->nullable();
            $table->string('celular', 20);

            // Recursos en casa
            $table->boolean('internet_casa')->nullable();                // Sí/No
            $table->boolean('equipo_computo')->nullable();               // Sí/No

            // Situación familiar y traslado
            $table->string('convivencia', 80)->nullable();               // con quién vives
            $table->string('tiempo_traslado', 20)->nullable();           // <15, 15–30, 30–60, >60

            // Identificación personal (en mayúsculas en la UI; aquí normal)
            $table->string('apellido_paterno', 120);
            $table->string('apellido_materno', 120)->nullable();
            $table->string('nombres', 180);

            // Periodo
            $table->string('periodo_ingreso', 10)->nullable();           // p.ej. 2024B

            // Plataformas/Medios (selección múltiple)
            $table->jsonb('plataformas_usadas')->nullable();             // p.ej. ["Teams","Classroom",...]
            $table->jsonb('medios_comunicacion')->nullable();            // p.ej. ["Zoom","Whatsapp",...]

            // Correo institucional
            $table->boolean('correo_institucional')->nullable();
            $table->string('uaem_email', 180)->nullable();

            // Condiciones especiales
            $table->boolean('vulnerabilidad_economica')->nullable();
            $table->boolean('condicion_medica')->nullable();

            // Escuela de procedencia (catálogo muy grande → string + “otro”)
            $table->string('escuela_procedencia', 255)->nullable();
            $table->string('escuela_procedencia_otro', 255)->nullable();

            // Extras/futuros campos del formulario
            $table->jsonb('extra')->nullable();

            // Estado del formulario
            $table->timestamp('submitted_at')->nullable();

            $table->timestamps(); // created_at / updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intake_forms');
    }
};

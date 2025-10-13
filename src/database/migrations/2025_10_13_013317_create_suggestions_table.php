<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();

            // Scope / segmentación
            $table->string('area', 40);                  // aritmetica|algebra|trigonometria|geometria_analitica
            $table->string('tag_tema', 160)->nullable(); // p.ej. "ecuaciones_lineales"

            // Contenido
            $table->string('titulo', 200);
            $table->string('tipo', 40);                  // texto|link|youtube|vimeo|pdf|imagen|video
            $table->text('url_o_asset')->nullable();     // URL externa o path de storage
            $table->text('descripcion')->nullable();

            // Umbrales (disparador por error)
            $table->smallInteger('umbral_min')->nullable(); // % de error mínimo
            $table->smallInteger('umbral_max')->nullable(); // % de error máximo

            // Scopes opcionales específicos
            $table->foreignId('quiz_id')->nullable()->constrained('quizzes')->nullOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('sections')->nullOnDelete();
            $table->foreignId('question_id')->nullable()->constrained('questions')->nullOnDelete();

            // Gestión
            $table->boolean('visible')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // Índices útiles
            $table->index(['area', 'tag_tema']);
            $table->index(['quiz_id', 'section_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};

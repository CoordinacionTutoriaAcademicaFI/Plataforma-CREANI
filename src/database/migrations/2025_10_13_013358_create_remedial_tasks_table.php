
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('remedial_tasks', function (Blueprint $table) {
            $table->id();

            // Asignación
            $table->foreignId('alumno_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mentor_id')->nullable()->constrained('users')->nullOnDelete(); // quien acompaña
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();         // admin|mentor que crea

            // Contenido
            $table->string('tema', 160);
            $table->text('descripcion')->nullable();

            // Vencimiento y estado
            $table->timestamp('vence_at')->nullable();
            $table->string('estado', 20)->default('asignada'); // asignada|entregada|aprobada|rechazada|vencida

            // Evidencias / vínculos
            $table->text('evidencia_url')->nullable();         // link a archivo/drive/storage
            $table->foreignId('suggestion_id')->nullable()->constrained('suggestions')->nullOnDelete();

            // (Opcional) vínculo al question/quiz que la originó
            $table->foreignId('quiz_id')->nullable()->constrained('quizzes')->nullOnDelete();
            $table->foreignId('question_id')->nullable()->constrained('questions')->nullOnDelete();

            $table->timestamps();

            // Índices
            $table->index(['alumno_id', 'estado']);
            $table->index(['mentor_id']);
            $table->index(['vence_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remedial_tasks');
    }
};

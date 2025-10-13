<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('attempts', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('alumno_id');
        $table->unsignedBigInteger('quiz_id');
        $table->timestamp('inicio_at');
        $table->timestamp('fin_at');
        $table->decimal('puntaje', 5, 2)->default(0);
        $table->json('detalle_por_seccion_json');
        $table->timestamps();

        $table->foreign('alumno_id')->references('id')->on('users')->cascadeOnDelete();
        $table->foreign('quiz_id')->references('id')->on('quizzes')->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('attempts');
}
};
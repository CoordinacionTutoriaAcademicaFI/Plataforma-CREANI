<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('answers', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('attempt_id');
        $table->unsignedBigInteger('question_id');
        $table->integer('opcion_idx');
        $table->boolean('es_correcta');
        $table->integer('tiempo_ms');
        $table->text('explicacion_html')->nullable();
        $table->timestamps();

        $table->foreign('attempt_id')->references('id')->on('attempts')->cascadeOnDelete();
        $table->foreign('question_id')->references('id')->on('questions')->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('answers');
}
};
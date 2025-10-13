<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('questions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('section_id');
        $table->text('enunciado_html');
        $table->text('latex')->nullable();
        $table->string('imagen_url')->nullable();
        $table->json('opciones_json');
        $table->integer('correcta_idx');
        $table->integer('dificultad')->default(1);
        $table->json('tags_json')->nullable();
        $table->timestamps();

        $table->foreign('section_id')->references('id')->on('sections')->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('questions');
}
};
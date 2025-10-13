<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('quizzes', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->text('descripcion')->nullable();
        $table->string('area');
        $table->string('tema');
        $table->timestamp('inicio_at');
        $table->timestamp('cierre_at');
        $table->enum('estado', ['borrador', 'publicado', 'cerrado'])->default('borrador');
        $table->unsignedBigInteger('created_by');
        $table->timestamps();

        $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('quizzes');
}
};
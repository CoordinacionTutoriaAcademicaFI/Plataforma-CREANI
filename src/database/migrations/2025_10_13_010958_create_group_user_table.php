<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('group_user', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('usuario_id');
        $table->unsignedBigInteger('grupo_id');
        $table->boolean('activo')->default(true);
        $table->timestamps();

        $table->foreign('usuario_id')->references('id')->on('users')->cascadeOnDelete();
        $table->foreign('grupo_id')->references('id')->on('groups')->cascadeOnDelete();
        $table->unique(['usuario_id', 'grupo_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('group_user');
}
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('groups', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 120);
        $table->integer('cupo')->default(30);
        $table->unsignedBigInteger('mentor_id');
        $table->unsignedBigInteger('profesor_id');
        $table->boolean('activo')->default(true);
        $table->timestamps();

        $table->foreign('mentor_id')->references('id')->on('users')->cascadeOnDelete();
        $table->foreign('profesor_id')->references('id')->on('professors')->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('groups');
}

};
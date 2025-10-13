<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('sections', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('quiz_id');
        $table->string('nombre');
        $table->integer('orden');
        $table->decimal('ponderacion', 5, 2)->default(0);
        $table->timestamps();

        $table->foreign('quiz_id')->references('id')->on('quizzes')->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::dropIfExists('sections');
}
};
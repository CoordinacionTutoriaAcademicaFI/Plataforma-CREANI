<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // draft = lo está contestando
            // submitted = ya lo envió y se califica
            $table->string('status')->default('draft'); // draft|submitted
            $table->unsignedInteger('puntaje_obtenido')->nullable();
            $table->unsignedInteger('puntaje_maximo')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->unique(['quiz_id','user_id']); // un intento por cuestionario
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};

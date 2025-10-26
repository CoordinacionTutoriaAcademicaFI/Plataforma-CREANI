<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('intake_forms', function (Blueprint $table) {
            if (!Schema::hasColumn('intake_forms', 'answers_json')) {
                $table->jsonb('answers_json')->nullable()->after('extra');
            }
        });
    }

    public function down(): void
    {
        Schema::table('intake_forms', function (Blueprint $table) {
            if (Schema::hasColumn('intake_forms', 'answers_json')) {
                $table->dropColumn('answers_json');
            }
        });
    }
};

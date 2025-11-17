<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('specialties')) {
            Schema::create('specialties', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // Ensure doctors table has specialty_id
        if (Schema::hasTable('doctors') && !Schema::hasColumn('doctors', 'specialty_id')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->foreignId('specialty_id')->nullable()->constrained('specialties')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('doctors') && Schema::hasColumn('doctors', 'specialty_id')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->dropConstrainedForeignId('specialty_id');
            });
        }
        Schema::dropIfExists('specialties');
    }
};

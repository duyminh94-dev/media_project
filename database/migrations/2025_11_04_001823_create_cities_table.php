<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // OPTIONAL: if doctors table exists and you want the FK now
        if (Schema::hasTable('doctors') && !Schema::hasColumn('doctors','city_id')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('doctors') && Schema::hasColumn('doctors','city_id')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->dropConstrainedForeignId('city_id');
            });
        }
        Schema::dropIfExists('cities');
    }
};

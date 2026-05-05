<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('one_time_operations', function (Blueprint $table) {
            $table->id();
            $table->string('operation');   // ✅ IMPORTANT (correct column)
            $table->timestamp('ran_at')->nullable(); // ✅ correct column
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('one_time_operations');
    }
};
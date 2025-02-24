<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('circuit_race', function (Blueprint $table) {
            $table->id();
            $table->foreignId('circuit_id')->constrained('circuits')->onDelete('cascade');
            $table->foreignId('race_id')->constrained('races')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circuit_race');
    }
};

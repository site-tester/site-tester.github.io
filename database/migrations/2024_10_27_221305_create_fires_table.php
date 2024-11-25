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
        Schema::create('fires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barangay_id')->constrained('barangays');
            $table->integer('total_incidents');
            $table->integer('high_severity_incidents');
            $table->integer('casualties');
            $table->integer('injuries');
            $table->integer('families_affected');
            $table->unsignedBigInteger('damages_php');
            $table->enum('risk_level', ['Low', 'Medium', 'High']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fires');
    }
};

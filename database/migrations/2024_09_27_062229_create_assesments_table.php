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
        Schema::create('assesments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barangay_id')->constrained('barangays');
            $table->integer('damage_level');
            $table->float('vulnerable_population_percentage',10,2);
            $table->integer('access_to_needs');
            $table->boolean('local_resource_available');
            $table->boolean('logistical_issues')->nullable();
            $table->integer('critical_needs');
            $table->integer('deteriotation_rate');
            $table->integer('urgency_score');
            $table->timestamp('sumitted_at');
            $table->foreignId('assesed_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assesments');
    }
};

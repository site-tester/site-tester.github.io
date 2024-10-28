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
        Schema::create('donation_status_logs', function (Blueprint $table) {
            $table->id();
            $table->string('donor_id');
            $table->string('barangay_id');
            $table->string('donation_id');
            $table->string('status');
            $table->string('status_change_proof');
            $table->string('status_change_remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_status_logs');
    }
};

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
        Schema::create('request_donations', function (Blueprint $table) {
            $table->id();
            $table->string('reported_by');
            $table->date('incident_date');
            $table->string('incident_time');
            $table->string('barangay_id');
            $table->string('exact_location');
            $table->json('preffered_donation_type')->nullable();
            $table->json('disaster_type');
            $table->string('caused_by');
            $table->string('immediate_needs_food')->nullable();
            $table->string('immediate_needs_nonfood')->nullable();
            $table->string('immediate_needs_medicine')->nullable();
            $table->string('overview');
            $table->date('date_requested');
            $table->string('affected_family')->nullable();
            $table->string('affected_person')->nullable();
            $table->string('vulnerability')->nullable()->default(0);
            $table->json('attachments');
            $table->string('status')->default('Pending Approval');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_donations');
    }
};

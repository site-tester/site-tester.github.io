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
            $table->string('barangay');
            $table->string('preffered_donation_type');
            $table->string('disaster_type');
            $table->date('date_requested');
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

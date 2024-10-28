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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('anonymous')->nullable()->default(false);
            $table->foreignId('donor_id')->constrained('users');
            $table->foreignId('barangay_id');
            $table->string('type');
            // $table->json('items');
            $table->date('donation_date');
            $table->string('donation_time');
            $table->string('proof_document')->nullable();
            $table->string('remarks')->nullable();
            $table->enum('status', [
                'Pending Approval',
                'Approved',
                'Awaiting Delivery',
                'Received',
                'Under Segregation',
                'Categorized',
                'In Inventory',
                'Ready for Distribution',
                'Distributed',
                'Completed'
            ])->default('Pending Approval');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};

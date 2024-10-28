<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barangay_id');
            // ->constrained('barangays')
            $table->foreignId('item_id');
            $table->integer('quantity');
            $table->foreignId('distributed_by')->constrained('users'); // ID of barangay rep from
            $table->foreignId('distributed_to')->constrained('users'); // ID of barangay 
            $table->date('distribution_date');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributions');
    }
};

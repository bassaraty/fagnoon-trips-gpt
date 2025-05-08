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
        Schema::create(
            'payments',
            function (Blueprint $table) {
                $table->id();
                // Polymorphic relationship to link payments to either a reservation (trip) or a birthday event
                $table->morphs('payable'); // Will create payable_id and payable_type
                $table->decimal('amount', 8, 2);
                $table->string('payment_method')->nullable(); // e.g., 'cash', 'card', 'bank_transfer'
                $table->string('transaction_id')->nullable(); // For online payments or reference
                $table->string('payment_proof_path')->nullable(); // Path to uploaded payment slip
                $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
                $table->timestamp('payment_date')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

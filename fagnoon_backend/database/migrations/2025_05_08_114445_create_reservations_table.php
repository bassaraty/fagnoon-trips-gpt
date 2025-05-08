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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who made the reservation (Agent/Leader)
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->string('school_name')->nullable(); // For trips
            $table->string('school_grade')->nullable(); // For trips
            $table->integer('number_of_students')->nullable(); // For trips
            $table->integer('number_of_supervisors')->nullable(); // For trips
            $table->date('reservation_date');
            $table->time('start_time');
            $table->time('end_time'); // Auto-calculated (4 hours duration)
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid', 'partial'])->default('unpaid');
            $table->timestamps();
        });

        // Pivot table for reservations and activities (many-to-many)
        Schema::create('activity_reservation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_reservation');
        Schema::dropIfExists('reservations');
    }
};

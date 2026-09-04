<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->restrictOnDelete();
            $table->timestamp('clock_in_at');
            $table->decimal('clock_in_lat', 10, 7);
            $table->decimal('clock_in_lng', 10, 7);
            $table->decimal('clock_in_accuracy', 10, 2)->nullable();
            $table->decimal('clock_in_distance_meters', 10, 2);
            $table->timestamp('clock_out_at')->nullable();
            $table->decimal('clock_out_lat', 10, 7)->nullable();
            $table->decimal('clock_out_lng', 10, 7)->nullable();
            $table->decimal('clock_out_accuracy', 10, 2)->nullable();
            $table->decimal('clock_out_distance_meters', 10, 2)->nullable();
            $table->enum('status', ['on_time', 'late'])->default('on_time');
            $table->unsignedInteger('late_minutes')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'clock_in_at']);
            $table->index(['branch_id', 'clock_in_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};

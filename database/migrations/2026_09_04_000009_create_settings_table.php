<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('primary_color', 20)->default('#2563EB');
            $table->string('secondary_color', 20)->default('#0F172A');
            $table->string('timezone')->default('Africa/Lagos');
            $table->time('work_start_time')->default('08:00:00');
            $table->time('late_after_time')->default('08:15:00');
            $table->time('work_end_time')->default('17:00:00');
            $table->unsignedInteger('task_due_soon_hours')->default(24);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

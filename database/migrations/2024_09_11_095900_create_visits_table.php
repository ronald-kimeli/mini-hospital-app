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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->timestamp('check_in_time')->required();
            $table->timestamp('check_out_time')->nullable();
            $table->enum('current_stage', ['triage', 'doctor', 'laboratory', 'radiology', 'optical', 'checked_out', 'reception'])
                ->default('reception');
            $table->text('stages')->nullable();
            $table->boolean('checked_out')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};

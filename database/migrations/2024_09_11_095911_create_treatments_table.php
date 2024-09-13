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
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained()->onDelete('restrict');
            $table->foreignId('patient_id')->constrained()->onDelete('restrict');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('restrict');
            $table->text('doctor_notes')->nullable();
            $table->text('laboratory_notes')->nullable();
            $table->text('radiology_notes')->nullable();
            $table->text('optician_notes')->nullable();
            $table->dateTime('doctor_notes_time')->nullable();
            $table->dateTime('laboratory_notes_time')->nullable();
            $table->dateTime('radiology_notes_time')->nullable();
            $table->dateTime('optician_notes_time')->nullable();
            $table->text('treatment_provided');
            $table->dateTime('date_of_treatment');
            $table->decimal('price', 10, 2);
            $table->enum('status', ['pending', 'completed']);
            $table->boolean('doctor_seen')->default(false);
            $table->boolean('laboratory_seen')->default(false);
            $table->boolean('radiology_seen')->default(false);
            $table->boolean('optician_seen')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};

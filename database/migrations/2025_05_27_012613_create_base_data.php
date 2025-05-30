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
        Schema::create('polyclinics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->unsignedTinyInteger('type')->default(1);
            $table->integer('capacity')->default(0);
            $table->timestamps();
        });

        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('specialization');
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->foreign('nik')->references('nik')->on('users')->onDelete('cascade');
        });
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->string('day'); // 'Senin', 'Selasa', etc.
            $table->time('time_from');
            $table->time('time_to');
            $table->integer('max_capacity')->default(10);
            $table->foreignId('polyclinic_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('doctor_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->default(0);
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        Schema::create('medical_history', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')
                ->constrained()->cascadeOnDelete();

            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained()->nullOnDelete();

            $table->string('queue_number')->nullable();
            $table->string('booking_code')->nullable();

            $table->date('visit_date');
            $table->time('visit_time');

            $table->text('chief_complaint')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->text('prescription')->nullable();

            $table->text('doctor_notes')->nullable();
            $table->date('follow_up_date')->nullable();

            $table->unsignedTinyInteger('status')
                ->default(1)
                ->comment('1=Draft,2=Final');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // urutan DROP dibalik agar tidak melanggar FK
        Schema::dropIfExists('medical_histories');
        Schema::dropIfExists('doctor_reviews');
        Schema::dropIfExists('doctor_schedules');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('polyclinics');
    }
};
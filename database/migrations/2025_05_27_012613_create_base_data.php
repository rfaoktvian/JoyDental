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
            $table->unsignedTinyInteger('category')->default(1);
            $table->time('open_time');
            $table->time('close_time');
            $table->integer('capacity')->default(0);
            $table->timestamps();
        });

        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('name');
            $table->string('specialization');
            $table->string('practice_location')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->foreign('nik')->references('nik')->on('users')->onDelete('cascade');
        });

        Schema::create('appointment_ticket', function (Blueprint $table) {
            $table->id();
            $table->string('queue_number');
            $table->string('booking_code')->unique();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');

            $table->foreignId('polyclinic_id')->constrained('polyclinics')->onDelete('cascade');

            $table->enum('status', [1, 2, 3])->default(1);
            $table->date('appointment_date');
            $table->time('appointment_time')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('consultation_fee')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_ticket');
    }
};
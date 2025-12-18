<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->string('order_code', 50)->unique();
            $table->decimal('amount', 10, 2)->default(50000.00);
            $table->enum('status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->string('snap_token')->nullable();
            $table->timestamps();
            
            $table->index('order_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
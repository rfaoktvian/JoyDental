<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('transaction_id')->nullable()->unique();
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->text('payment_response')->nullable();
            $table->timestamps();
            
            $table->index('transaction_id');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
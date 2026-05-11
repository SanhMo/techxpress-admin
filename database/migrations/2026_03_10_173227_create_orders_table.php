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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_code')->unique(); // VD: TX-20250310-0001
            $table->decimal('total', 15, 0);
            $table->decimal('deposit', 15, 0)->default(0); // tiền cọc
            $table->string('payment_method'); // cod, bank_deposit, ewallet_deposit
            $table->enum('payment_status', ['pending', 'deposited', 'paid'])->default('pending');
            $table->enum('status', ['pending', 'confirmed', 'shipping', 'delivered', 'cancelled'])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

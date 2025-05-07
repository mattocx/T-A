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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('order_id')->unique(); // ID unik untuk transaksi Midtrans
            $table->string('transaction_id')->nullable(); // ID transaksi dari Midtrans
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->dateTime('payment_date')->nullable();
            $table->dateTime('due_date'); // Tanggal jatuh tempo
            $table->string('payment_method')->nullable();
            $table->text('snap_token')->nullable(); // Token Snap dari Midtrans
            $table->text('payment_url')->nullable(); // URL pembayaran
            $table->text('payment_details')->nullable(); // Detail pembayaran dalam format JSON
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

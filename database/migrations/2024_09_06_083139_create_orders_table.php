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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siparişi veren kullanıcı
            $table->foreignId('business_id')->constrained()->onDelete('cascade'); //işletme
            $table->string('order_status');
            $table->string('payment_status'); 
            $table->decimal('total', 10, 2); // Sipariş toplam tutarı
            $table->string('payment_method')->default('credit_card'); 
            $table->string('payment_reference')->nullable();
            $table->timestamps();
            $table->softDeletes();
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

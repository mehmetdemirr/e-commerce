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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2); // Örnek: 999999.99
            $table->integer('quantity');
            $table->string('sku')->unique(); // SKU, benzersiz olmalıdır
            $table->unsignedBigInteger('category_id')->nullable(); // Kategoriler nullable olabilir
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('brand_id')->nullable(); // Marka nullable olabilir
            $table->decimal('discount', 5, 2)->nullable(); // Örnek: 99.99
            $table->decimal('shipping_cost', 8, 2)->nullable(); // Örnek: 99.99
            $table->decimal('weight', 8, 2)->nullable(); // Örnek: 99.99
            $table->string('dimensions')->nullable();
            $table->integer('views')->default(0);
            $table->integer('sales')->default(0);
            $table->decimal('rating', 2, 1)->default(0.0); // Örnek: 4.5
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps(); 

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

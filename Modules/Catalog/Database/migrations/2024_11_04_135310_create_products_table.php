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
            $table->bigInteger('category_id')->unsigned()->index()->nullable();
            $table->string('name')->unique();
            $table->string('image')->nullable();
            $table->decimal('price',9,2);
            $table->bigInteger('stock_quantity')->default(0);
            $table->boolean('is_a_service')->default(0);
            $table->string('unit');
            $table->decimal('last_purchase_price',9,2)->default(0);
            $table->string('barcode')->nullable();
            $table->boolean('active')->default(1);

            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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

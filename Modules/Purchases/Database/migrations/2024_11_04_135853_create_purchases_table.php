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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->bigInteger('contact_id')->unsigned()->index()->nullable();
            $table->bigInteger('sub_total')->default(0);
            $table->decimal('tax',9,2)->default(0);
            $table->decimal('discount',9,2)->default(0);
            $table->decimal('grand_total',9,2)->default(0);
            $table->string('status');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};

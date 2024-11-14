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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable(); // individual - company 
            $table->string('name')->unique();
            $table->string('email')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('address')->nullable();
            $table->text('note')->nullable();
            $table->string('sales_person_name')->nullable();
            $table->string('sales_person_email')->nullable();
            $table->string('sales_person_mobile_number')->nullable();
            $table->text('sales_person_note')->nullable();
            $table->string('purchase_person_name')->nullable();
            $table->string('purchase_person_email')->nullable();
            $table->string('purchase_person_mobile_number')->nullable();
            $table->text('purchase_person_note')->nullable();
            $table->integer('default_on_sales')->default(0);
            $table->integer('default_on_purchases')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};

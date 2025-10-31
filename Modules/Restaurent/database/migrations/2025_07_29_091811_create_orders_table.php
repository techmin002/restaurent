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
            $table->bigIncrements('id');
            $table->integer('customer_id');
            $table->integer('table_id')->nullable();
            $table->integer('office_id')->nullable();
            $table->integer('restaurent_id');
            $table->integer('created_by');
            $table->string('order_type');
            $table->string('discount_type')->nullable();
            $table->integer('discount_value')->nullable();
            $table->integer('discount_amount')->nullable();
            $table->integer('delivery_charge')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('sub_total');
            $table->integer('grand_total');
            $table->string('status')->default('pending');
            $table->dateTime('order_time')->nullable();
            $table->string('order_from')->nullable();
            $table->softDeletes();
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

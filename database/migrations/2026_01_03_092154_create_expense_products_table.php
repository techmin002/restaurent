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
        Schema::create('expense_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id');

            $table->string('product_name');
            $table->integer('product_qty');
            $table->decimal('product_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->integer('restaurent_id')->nullable();
            $table->string('status')->default('active');

            $table->timestamps();

            $table->foreign('expense_id')
                ->references('id')
                ->on('expenses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_products');
    }
};

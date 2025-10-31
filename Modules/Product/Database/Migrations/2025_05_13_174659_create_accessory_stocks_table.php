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
        Schema::create('accessory_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('accessory_id');
            $table->integer('branch_id');
            $table->integer('stock_in');
            $table->integer('total_stock');
            $table->integer('stock_alert')->default(2);
            $table->string('created_by')->nullable();
            $table->string('status')->default('on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessory_stocks');
    }
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machineries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('original_price')->nullable();
            $table->integer('sales_price')->nullable();
            $table->integer('remaining_qty')->nullable();
            $table->string('brand_id');
            $table->string('offer_status')->nullable();
            $table->string('category_id');
            $table->string('units')->nullable();
            $table->longText('description')->nullable();
            $table->longText('feature')->nullable();
            $table->string('image')->nullable();
            $table->text('images')->nullable();
            $table->string('status')->default(0);
            $table->string('backend_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machineries');
    }
};

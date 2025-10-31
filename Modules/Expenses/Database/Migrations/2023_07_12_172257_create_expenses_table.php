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
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('expense_category_id');
            $table->string('title');
            $table->string('amount');
            $table->date('date');
            $table->string('mode');
            $table->string('branch_id')->nullable();
            $table->string('created_by')->nullable();
            $table->text('description')->nullable();
            $table->string('receipt')->nullable();
            $table->string('status')->default('on');
            $table->softDeletes();
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
        Schema::dropIfExists('expenses');
    }
};

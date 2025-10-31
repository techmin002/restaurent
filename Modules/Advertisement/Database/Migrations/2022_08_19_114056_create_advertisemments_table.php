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
        Schema::create('advertisemments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('button_text')->nullable();
            $table->string('link')->nullable();
            $table->string('page');
            $table->string('position');
            $table->string('branch_id')->nullable();
            $table->string('created_by')->nullable();
            $table->string('image');
            $table->text('description')->nullable();
            $table->timestamp('expire_date');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('advertisemments');
    }
};

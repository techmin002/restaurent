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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('no_of_opening');
            $table->string('type');
            $table->string('image');
            $table->text('short_description')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('created_by')->nullable();
            $table->longText('description');
            $table->timestamp('expire_at');
            $table->string('status');
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
        Schema::dropIfExists('vacancies');
    }
};

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
        Schema::create('restaurent_tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('table_number');
            $table->integer('restaurent_id');
            $table->integer('section_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('capacity')->nullable();
            $table->text('qr_code_path')->nullable();
            $table->string('status')->default('available');
            $table->string('booking_status')->default('no');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurent_tables');
    }
};

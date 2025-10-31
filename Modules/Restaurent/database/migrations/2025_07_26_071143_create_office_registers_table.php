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
        Schema::create('office_registers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->integer('restaurent_id');
            $table->string('type')->default('office');
            $table->integer('created_by')->nullable();
            $table->text('contact_numbers')->nullable();
            $table->string('owner_name')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('office_registers');
    }
};

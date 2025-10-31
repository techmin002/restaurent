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
        Schema::create('emi_systems', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('downpayment_percentage');
            $table->string('interest_rate');
            $table->string('duration_month');
            $table->string('created_by');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emi_systems');
    }
};

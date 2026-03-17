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
        Schema::create('customer_says', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // Customer Name
            $table->string('working')->nullable();   // Work / Company / Position
            $table->string('image')->nullable();     // Profile image
            $table->text('description');             // Review / Feedback
            $table->enum('status', ['on', 'off'])->default('on'); // Active/Inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_says');
    }
};

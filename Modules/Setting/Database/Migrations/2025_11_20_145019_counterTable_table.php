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
        Schema::create('counters', function (Blueprint $table) {
            $table->id(); // primary key
            $table->timestamp('date')->useCurrent(); // stores current date and time automatically
            $table->string('day')->nullable(); // you can store the day name like "Monday"
            $table->string('type')->nullable(); // type of counter (optional)

            // Cash columns
            $table->decimal('cash_opening', 12, 2)->default(0);
            $table->decimal('cash_closing', 12, 2)->default(0);

            // Bank columns
            $table->decimal('bank_opening', 12, 2)->default(0);
            $table->decimal('bank_closing', 12, 2)->default(0);

            // Deposit
            $table->decimal('deposit', 12, 2)->default(0);

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counters');
    }
};

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
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('name');
            $table->unsignedBigInteger('restaurent_id')->nullable(false)->after('created_by');

            // If you want foreign keys, uncomment and adjust table names:
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('restaurent_id')->references('id')->on('restaurents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // If you added foreign keys, drop them first:
            // $table->dropForeign(['created_by']);
            // $table->dropForeign(['restaurent_id']);

            $table->dropColumn(['created_by', 'restaurent_id']);
        });
    }
};

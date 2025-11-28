<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'is_Reception/is_Kitchen')) {
                $table->dropColumn('is_Reception/is_Kitchen');
            }
        });
    }

    public function down(): void
    {
       Schema::table('orders', function (Blueprint $table) {
            $table->string('is_Reception/is_Kitchen')->default('Reception');
        }); 
    }
};

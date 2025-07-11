<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
             if (!Schema::hasColumn('orders', 'payment_status')) {
            $table->enum('payment_status', ['unpaid','paid'])
                  ->default('unpaid')
                  ->after('status');
        }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_status')) {
            $table->dropColumn('payment_status');
            }
        });
    }
};

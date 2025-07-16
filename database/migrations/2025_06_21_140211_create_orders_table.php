<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->decimal('total', 10, 2);
            $table->enum('delivery_state', ['pending','shipped','delivered','pickup']);
            $table->string('payment_method');
            $table->enum('payment_status', ['pending','paid','failed','refunded']);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('orders');
    }
};
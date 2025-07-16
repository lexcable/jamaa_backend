<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('time_entries', function(Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->time('check_in');
            $table->time('check_out');
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('time_entries'); }
};
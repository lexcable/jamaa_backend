<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('teams', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('image');
            $table->string('department');
            $table->string('position');
            $table->string('role');
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('teams'); }
};
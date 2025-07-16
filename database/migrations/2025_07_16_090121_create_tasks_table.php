<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('tasks', function(Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('assignee');
            $table->date('deadline');
            $table->enum('status',['assigned','in_progress','completed']);
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('tasks'); }
};
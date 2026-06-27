<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('task_items', function (Blueprint $table) {
            $table->id('task_id');
            $table->foreignId('channel_id')->constrained('channels', 'channel_id');
            $table->foreignId('message_id')->constrained('messages', 'message_id');
            $table->foreignId('assignee_id')->constrained('users', 'user_id');
            $table->foreignId('creator_id')->constrained('users', 'user_id');
            $table->text('description');
            $table->enum('status', ['Open', 'In Progress', 'Completed'])->default('Open');
            $table->date('due_date')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }
    public function down() { Schema::dropIfExists('task_items'); }
};
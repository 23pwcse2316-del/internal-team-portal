<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Create the messages table WITHOUT foreign keys first
        Schema::create('messages', function (Blueprint $table) {
            $table->id('message_id');
            $table->unsignedBigInteger('channel_id');
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('parent_message_id')->nullable();
            $table->text('content');
            $table->boolean('is_pinned')->default(false);
            $table->timestamp('pinned_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('edited_at')->nullable();
        });

        // Add all foreign keys after the table is created
        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('channel_id')
                  ->references('channel_id')
                  ->on('channels');

            $table->foreign('author_id')
                  ->references('user_id')
                  ->on('users');

            $table->foreign('parent_message_id')
                  ->references('message_id')
                  ->on('messages');
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
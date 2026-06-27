<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('private_channel_memberships', function (Blueprint $table) {
            $table->id('pcm_id');
            $table->foreignId('channel_id')->constrained('private_channels', 'channel_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->foreignId('invited_by')->constrained('users', 'user_id');
            $table->timestamp('joined_at')->useCurrent();
            $table->unique(['channel_id', 'user_id']);
        });
    }
    public function down() { Schema::dropIfExists('private_channel_memberships'); }
};
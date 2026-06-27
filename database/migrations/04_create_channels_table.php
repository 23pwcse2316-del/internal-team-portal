<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id('channel_id');
            $table->foreignId('workspace_id')->constrained('workspaces', 'workspace_id');
            $table->string('channel_name', 100);
            $table->enum('channel_type', ['Public', 'Private']);
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['workspace_id', 'channel_name']);
        });
    }
    public function down() { Schema::dropIfExists('channels'); }
};
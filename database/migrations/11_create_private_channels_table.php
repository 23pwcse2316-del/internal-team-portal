<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('private_channels', function (Blueprint $table) {
            $table->foreignId('channel_id')->constrained('channels', 'channel_id')->primary();
            $table->boolean('invite_only')->default(true);
        });
    }
    public function down() { Schema::dropIfExists('private_channels'); }
};
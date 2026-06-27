<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('public_channels', function (Blueprint $table) {
            $table->foreignId('channel_id')->constrained('channels', 'channel_id')->primary();
            $table->boolean('is_default')->default(false);
        });
    }
    public function down() { Schema::dropIfExists('public_channels'); }
};
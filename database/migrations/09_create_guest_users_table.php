<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('guest_users', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users', 'user_id')->primary();
            $table->foreignId('invited_by')->constrained('users', 'user_id');
            $table->timestamp('guest_expires_at');
        });
    }
    public function down() { Schema::dropIfExists('guest_users'); }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users', 'user_id')->primary();
            $table->boolean('can_invite')->default(true);
            $table->timestamp('admin_since')->useCurrent();
        });
    }
    public function down() { Schema::dropIfExists('admin_users'); }
};
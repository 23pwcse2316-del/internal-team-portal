<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('workspace_memberships', function (Blueprint $table) {
            $table->id('membership_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->foreignId('workspace_id')->constrained('workspaces', 'workspace_id');
            $table->enum('role', ['Admin', 'Member', 'Guest'])->default('Member');
            $table->timestamp('joined_at')->useCurrent();
            $table->unique(['user_id', 'workspace_id']);
        });
    }
    public function down() { Schema::dropIfExists('workspace_memberships'); }
};
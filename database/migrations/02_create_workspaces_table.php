<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id('workspace_id');
            $table->string('workspace_name', 100);
            $table->foreignId('creator_id')->constrained('users', 'user_id');
            $table->timestamp('created_at')->useCurrent();
        });
    }
    public function down() { Schema::dropIfExists('workspaces'); }
};
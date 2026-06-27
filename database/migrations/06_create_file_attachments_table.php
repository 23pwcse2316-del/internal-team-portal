<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('file_attachments', function (Blueprint $table) {
            $table->id('attachment_id');
            $table->unsignedBigInteger('message_id');
            $table->string('file_name', 255);
            $table->string('file_url', 500);
            $table->string('storage_key', 255);
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('file_size_bytes');
            $table->timestamp('uploaded_at')->useCurrent();
            $table->unique(['file_url', 'storage_key']);
        });

        Schema::table('file_attachments', function (Blueprint $table) {
            $table->foreign('message_id')->references('message_id')->on('messages')->onDelete('cascade');
        });
    }
    public function down() { Schema::dropIfExists('file_attachments'); }
};
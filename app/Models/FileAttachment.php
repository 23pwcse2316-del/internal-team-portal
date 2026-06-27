<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileAttachment extends Model
{
    use HasFactory;

    protected $primaryKey = 'attachment_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'file_attachments';
    public $timestamps = false;

    protected $fillable = [
        'message_id', 'file_name', 'file_url', 'storage_key',
        'mime_type', 'file_size_bytes', 'uploaded_at',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id', 'message_id');
    }

    // Get human-readable file size
    public function getFileSizeAttribute()
    {
        $bytes = $this->file_size_bytes;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    // Get file icon based on mime type
    public function getFileIconAttribute()
    {
        $icons = [
            'image' => '🖼️',
            'video' => '🎬',
            'audio' => '🎵',
            'pdf' => '📄',
            'word' => '📝',
            'excel' => '📊',
            'zip' => '📦',
            'code' => '💻',
        ];

        $mimeType = $this->mime_type;
        
        if (str_contains($mimeType, 'image')) return $icons['image'];
        if (str_contains($mimeType, 'video')) return $icons['video'];
        if (str_contains($mimeType, 'audio')) return $icons['audio'];
        if (str_contains($mimeType, 'pdf')) return $icons['pdf'];
        if (str_contains($mimeType, 'word') || str_contains($mimeType, 'document')) return $icons['word'];
        if (str_contains($mimeType, 'excel') || str_contains($mimeType, 'sheet')) return $icons['excel'];
        if (str_contains($mimeType, 'zip') || str_contains($mimeType, 'compressed')) return $icons['zip'];
        if (str_contains($mimeType, 'text') || str_contains($mimeType, 'javascript') || str_contains($mimeType, 'json')) return $icons['code'];
        
        return '📎';
    }
}
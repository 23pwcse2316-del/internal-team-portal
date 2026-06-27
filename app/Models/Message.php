<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'message_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'messages';
    public $timestamps = false;

    protected $fillable = [
        'channel_id', 'author_id', 'parent_message_id', 'content',
        'is_pinned', 'pinned_at', 'created_at', 'edited_at',
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'channel_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_message_id', 'message_id');
    }

    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_message_id', 'message_id')
                    ->orderBy('created_at', 'asc');
    }

    public function attachments()
    {
        return $this->hasMany(FileAttachment::class, 'message_id', 'message_id');
    }

    public function tasks()
    {
        return $this->hasMany(TaskItem::class, 'message_id', 'message_id');
    }

    public function togglePin()
    {
        $this->is_pinned = !$this->is_pinned;
        $this->pinned_at = $this->is_pinned ? now() : null;
        $this->save();
        return $this;
    }

    public function isEdited()
    {
        return !is_null($this->edited_at);
    }

    public function canEdit($user)
    {
        return $user && ($this->author_id === $user->user_id);
    }

    public function canDelete($user, $isAdmin = false)
    {
        return $user && ($this->author_id === $user->user_id || $isAdmin);
    }
}
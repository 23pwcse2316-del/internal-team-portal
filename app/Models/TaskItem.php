<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'task_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'task_items';
    public $timestamps = false;

    protected $fillable = [
        'channel_id', 'message_id', 'assignee_id', 'creator_id',
        'description', 'status', 'due_date', 'created_at',
    ];

    // Relationships
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'channel_id');
    }

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id', 'message_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id', 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'user_id');
    }

    // Status badge colors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Open' => 'bg-gray-100 text-gray-800',
            'In Progress' => 'bg-yellow-100 text-yellow-800',
            'Completed' => 'bg-green-100 text-green-800',
        ];
        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    // Status icon
    public function getStatusIconAttribute()
    {
        $icons = [
            'Open' => '🟡',
            'In Progress' => '🔵',
            'Completed' => '✅',
        ];
        return $icons[$this->status] ?? '📋';
    }
}
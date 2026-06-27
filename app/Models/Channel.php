<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $primaryKey = 'channel_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'channels';
    public $timestamps = false;

    protected $fillable = [
        'workspace_id', 'channel_name', 'channel_type', 'created_at',
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class, 'workspace_id', 'workspace_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'channel_id', 'channel_id');
    }

    public function publicChannel()
    {
        return $this->hasOne(PublicChannel::class, 'channel_id', 'channel_id');
    }

    public function privateChannel()
    {
        return $this->hasOne(PrivateChannel::class, 'channel_id', 'channel_id');
    }

    public function isPrivateChannelMember($user_id)
    {
        if ($this->channel_type === 'Public') {
            return true;
        }
        return $this->privateChannel()
            ->whereHas('members', function($query) use ($user_id) {
                $query->where('private_channel_memberships.user_id', $user_id);
            })->exists();
    }

    public function getPrivateMembers()
    {
        if ($this->channel_type === 'Public') {
            return $this->workspace->members;
        }
        return $this->privateChannel->members;
    }
}
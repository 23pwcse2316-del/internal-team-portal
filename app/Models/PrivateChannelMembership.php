<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateChannelMembership extends Model
{
    use HasFactory;

    protected $primaryKey = 'pcm_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'private_channel_memberships';
    public $timestamps = false;

    protected $fillable = [
        'channel_id', 'user_id', 'invited_by', 'joined_at',
    ];

    public function channel()
    {
        return $this->belongsTo(PrivateChannel::class, 'channel_id', 'channel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function invitedBy()
    {
        return $this->belongsTo(User::class, 'invited_by', 'user_id');
    }
}
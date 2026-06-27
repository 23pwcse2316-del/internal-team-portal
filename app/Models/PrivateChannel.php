<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateChannel extends Model
{
    use HasFactory;

    protected $primaryKey = 'channel_id';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $table = 'private_channels';
    public $timestamps = false;

    protected $fillable = [
        'channel_id', 'invite_only',
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'channel_id');
    }

    // This relationship must exist
    public function members()
    {
        return $this->belongsToMany(User::class, 'private_channel_memberships', 'channel_id', 'user_id')
                    ->withPivot('invited_by', 'joined_at');
    }
}
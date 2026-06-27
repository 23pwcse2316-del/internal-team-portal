<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $table = 'guest_users';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'invited_by', 'guest_expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function invitedBy()
    {
        return $this->belongsTo(User::class, 'invited_by', 'user_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $table = 'admin_users';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'can_invite', 'admin_since',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
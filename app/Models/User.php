<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'username', 'email', 'password_hash', 'user_type', 'created_at',
    ];

    protected $hidden = [
        'password_hash', 'remember_token',
    ];

    // 🔥 Tell Laravel to use 'password_hash' for authentication
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // 🔥 Tell Laravel's password reset to use 'password_hash'
    public function getAuthPasswordName()
    {
        return 'password_hash';
    }

    public function workspaces()
    {
        return $this->belongsToMany(Workspace::class, 'workspace_memberships', 'user_id', 'workspace_id')
                    ->withPivot('role', 'joined_at');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'author_id', 'user_id');
    }

    public function createdWorkspaces()
    {
        return $this->hasMany(Workspace::class, 'creator_id', 'user_id');
    }
}
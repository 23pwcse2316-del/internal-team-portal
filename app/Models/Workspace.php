<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    protected $primaryKey = 'workspace_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'workspaces';
    public $timestamps = false;

    protected $fillable = [
        'workspace_name', 'creator_id', 'created_at',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'user_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'workspace_memberships', 'workspace_id', 'user_id')
                    ->withPivot('role', 'joined_at');
    }

    public function channels()
    {
        return $this->hasMany(Channel::class, 'workspace_id', 'workspace_id');
    }
}
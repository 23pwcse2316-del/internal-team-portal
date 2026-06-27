<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkspaceMembership extends Model
{
    use HasFactory;

    protected $primaryKey = 'membership_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'workspace_memberships';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'workspace_id', 'role', 'joined_at',
    ];
}
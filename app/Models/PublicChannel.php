<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicChannel extends Model
{
    use HasFactory;

    protected $primaryKey = 'channel_id';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $table = 'public_channels';
    public $timestamps = false;

    protected $fillable = [
        'channel_id', 'is_default',
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'channel_id');
    }
}
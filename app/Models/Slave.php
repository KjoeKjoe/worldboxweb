<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slave extends Model
{
    use HasFactory;

    protected $fillable = [
        "firstName",
        "nickname",
        "is_twitch",
        "currency",
        "spawned",
        "gender",
        "age",
        "kills",
        "children",
        "base_health",
        "health",
        "base_diplomacy",
        "diplomacy",
        "base_warfare",
        "warfare",
        "base_stewardship",
        "stewardship",
        "base_intelligence",
        "intelligence",
        "traits"
    ];
}

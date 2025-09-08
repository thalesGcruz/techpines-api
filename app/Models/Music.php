<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Music extends Model
{
    /** @use HasFactory<\Database\Factories\DepartamentFactory> */
    use HasFactory;

    protected $fillable = [
        "title",
        "views",
        "youtube_id",
        "thumb",
        "status"
    ];
}

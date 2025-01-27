<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortenedUrl extends Model
{
    /** @use HasFactory<\Database\Factories\ShortedUrlFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'shortened_urls';

    protected $fillable = [
        'url',
        'shortened_url',
        'last_used',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'last_used' => 'datetime',
    ];

}

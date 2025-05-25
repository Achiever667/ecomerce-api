<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMSPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'banner_image',
        'banner_link',
        'is_archived',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
    ];
}

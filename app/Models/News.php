<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'status',
        'published_at', 'image', 'category', 'badge_color', 'is_featured',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_featured' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->orderByDesc('published_at');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getBadgeClassAttribute(): string
    {
        return match($this->badge_color) {
            'danger'  => 'bg-danger',
            'success' => 'bg-success',
            'warning' => 'bg-warning text-dark',
            'info'    => 'bg-info text-dark',
            default   => 'bg-primary',
        };
    }
}

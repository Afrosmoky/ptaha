<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'seo_title',
        'seo_description',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function sections()
    {
        return $this->hasMany(PageSection::class)
            ->orderBy('sort_order');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Max, null, 100)
            ->sharpen(10)
            ->nonQueued();
    }
}

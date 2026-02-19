<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

class Project extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'title',
        'slug',
        'type', // building / interior
        'description',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->useDisk('public')
            ->withResponsiveImages();

        $this->addMediaCollection('hero')
            ->singleFile()
            ->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Max, null, 350)
            ->sharpen(10)
            ->nonQueued();
    }
}

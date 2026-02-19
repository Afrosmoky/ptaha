<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PageSection extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'page_id',
        'type',
        'data',
        'sort_order',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->useDisk('public');
    }
}

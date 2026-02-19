<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class MenuItem extends Model
{
    protected $fillable = [
        'label',
        'url',
        'page_id',
        'sort_order',
        'is_active',
    ];

    protected static function booted()
    {
        static::saved(fn () => Cache::forget('main_menu'));
        static::deleted(fn () => Cache::forget('main_menu'));
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function getHrefAttribute(): string
    {
        if ($this->page) {
            return route('page.show', $this->page->slug);
        }

        return $this->url ?? '#';
    }

    public function isActive(): bool
    {
        $currentPath = trim(request()->path(), '/');

        $targetPath = parse_url($this->href, PHP_URL_PATH);
        $targetPath = trim($targetPath ?? '', '/');

        if ($currentPath === $targetPath) {
            return true;
        }

        if ($targetPath !== '' && str_starts_with($currentPath, $targetPath . '/')) {
            return true;
        }

        foreach ($this->children as $child) {
            $childPath = parse_url($child->href, PHP_URL_PATH);
            $childPath = trim($childPath ?? '', '/');

            if ($currentPath === $childPath) {
                return true;
            }

            if ($childPath !== '' && str_starts_with($currentPath, $childPath . '/')) {
                return true;
            }
        }

        return false;
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->orderBy('sort_order');
    }
}

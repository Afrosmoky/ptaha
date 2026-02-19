<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\MenuItem;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $menu = Cache::rememberForever('main_menu', function () {
                return MenuItem::whereNull('parent_id')
                    ->where('is_active', true)
                    ->with(['children' => function ($q) {
                        $q->where('is_active', true);
                    }])
                    ->orderBy('sort_order')
                    ->get();
            });

            $view->with('mainMenu', $menu);
        });
    }
}

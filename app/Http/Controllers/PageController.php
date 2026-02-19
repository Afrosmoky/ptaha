<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'page' => Page::where('slug', 'home')
                ->whereNotNull('published_at')
                ->first(),
        ]);
    }

    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->whereNotNull('published_at')
            ->firstOrFail();


        return view('pages.show', compact('page'));
    }
}

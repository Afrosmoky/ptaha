<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ContactController;


Route::get('/', [PageController::class, 'show'])
    ->defaults('slug', 'o-nas')
    ->name('home');

Route::get('/projekty', [ProjectController::class, 'index'])->name('projects.index');

Route::get('/{page:slug}', [PageController::class, 'show'])
    ->name('page.show');

Route::get('/projekty/{type}', [ProjectController::class, 'type'])
    ->name('projects.type');

Route::delete('/media/{media}', [MediaController::class, 'destroy'])
    ->name('media.delete')
    ->middleware(['auth']);

Route::post('/kontakt', [ContactController::class, 'send'])
    ->name('contact.send');


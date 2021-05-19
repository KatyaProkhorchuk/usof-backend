<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('users', 'UsersCrudController');
    // Route::crud('posts', 'PostsCrudController');
    Route::crud('post', 'PostCrudController');
    Route::crud('categories', 'CategoriesCrudController');
    Route::crud('comments', 'CommentsCrudController');
}); // this should be the absolute last line of this file
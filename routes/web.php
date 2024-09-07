<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Route::get('/', function () {
//     return view('welcome');
// });


// Diğer statik dosyalar için
Route::get('/storage/{any}', function ($path) {
    if (Storage::exists($path)) {
        return response()->file(storage_path('app/' . $path));
    }
    abort(404);
})->where('any', '.*');

// Vue.js uygulamanız için catch-all route
Route::view('{any}', 'app')->where('any', '.*');
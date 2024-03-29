<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\BlogCRUDController;
Route::get('blog-list', [BlogCRUDController::class, 'index']);
Route::post('store-blog', [BlogCRUDController::class, 'store']);
Route::post('edit-blog', [BlogCRUDController::class, 'edit']);
Route::post('delete-blog', [BlogCRUDController::class, 'destroy']);
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('getdata', [App\Http\Controllers\HomeController::class, 'getdata'])->name('getdata');

Route::post('delete', [App\Http\Controllers\HomeController::class, 'delete'])->name('delete');

Route::post('edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit');

Route::post('update', [App\Http\Controllers\HomeController::class, 'update'])->name('update');


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return 'Cache cleared successfully!';
});

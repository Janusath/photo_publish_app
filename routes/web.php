<?php

use App\Http\Controllers\AuthendicationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PhotosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
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

// Route::get('/', function () {
//     return view('welcome');
// });

function set_active($route)
{

    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active show' : '';
    }

    return Request::path() == $route ? 'active show' : '';
}

Route::fallback(function()
{
    return view('error_page.error');

});



Route::get('/',[AuthendicationController::class,'login'])->name('login');
Route::get('/dashboard',[AuthendicationController::class,'index'])->name('dashboard');
Route::get('/admin_login',[AuthendicationController::class,'admin_login'])->name('admin_login');
Route::get('/admin_logout',[AuthendicationController::class,'admin_logout'])->name('admin_logout');


//  event routing
Route::get('/event', [EventController::class, 'index'])->name('event');
Route::post('/event_store',[EventController::class,'store'])->name('event_store');
Route::get('/event_show', [EventController::class, 'show'])->name('event_show');
Route::get('event_edit', [EventController::class, 'edit'])->name('event_edit');
Route::post('/event_update', [EventController::class, 'update'])->name('event_update');
Route::delete('/event_delete', [EventController::class, 'delete'])->name('event_delete');

//  category routing
Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::post('/category_store',[CategoryController::class,'store'])->name('category_store');
Route::get('/category_show', [CategoryController::class, 'show'])->name('category_show');
Route::get('category_edit', [CategoryController::class, 'edit'])->name('category_edit');
Route::post('category_update', [CategoryController::class, 'update'])->name('category_update');
Route::delete('/category_delete', [CategoryController::class, 'delete'])->name('category_delete');

//  category routing
Route::get('/photo', [PhotosController::class, 'index'])->name('photo');
Route::post('/photo_store',[PhotosController::class,'store'])->name('photo_store');
Route::get('/photo_show', [PhotosController::class, 'show'])->name('photo_show');
Route::get('photo_edit', [PhotosController::class, 'edit'])->name('photo_edit');
Route::post('photo_update', [PhotosController::class, 'update'])->name('photo_update');
Route::delete('/photo_delete', [PhotosController::class, 'delete'])->name('photo_delete');

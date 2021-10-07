<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::user()){
        return redirect(route('home'));
    }else{
        return view("auth.login");
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');

Route::post('/addCategory', [App\Http\Controllers\HomeController::class, 'addCategory'])->name('add_category');
Route::post('/deleteCategory', [App\Http\Controllers\HomeController::class, 'deleteCategory'])->name('delete_category');


Route::post('/addNote', [App\Http\Controllers\HomeController::class, 'addNote'])->name('add_note');
Route::post('/deleteNote', [App\Http\Controllers\HomeController::class, 'deleteNote'])->name('delete_note');
Route::post('/editteNote', [App\Http\Controllers\HomeController::class, 'editNote'])->name('edit_note');

Route::post('/addTasklist', [App\Http\Controllers\HomeController::class, 'addTasklist'])->name('add_tasklist');
Route::post('/deleteTasklist', [App\Http\Controllers\HomeController::class, 'deleteTasklist'])->name('delete_tasklist');
Route::post('/editTasklist', [App\Http\Controllers\HomeController::class, 'editTasklist'])->name('edit_tasklist');

Route::post('/editUser', [App\Http\Controllers\HomeController::class, 'editUser'])->name('edit_user');


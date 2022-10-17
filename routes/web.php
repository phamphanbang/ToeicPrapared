<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use Backpack\CRUD\app\Http\Controllers\AdminController;

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
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
});
Auth::routes(['login' => false, 'register' => false]);
Route::get('admin/login',[AdminLoginController::class,'index']);
Route::post('admin/login', [AdminLoginController::class, 'postLogin'])->name('admin.login');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

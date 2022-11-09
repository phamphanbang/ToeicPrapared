<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\TestTemplateController;
use App\Http\Controllers\User\HomePageController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/login', function () {
//     return view('login');
// });
Auth::routes(['login' => false, 'register' => false]);


Route::group(['prefix' => 'admin', 'middleware' => ['admin'], 'as' => 'admin.'], function () {
    Route::resource('user',UserController::class);
    Route::post('user/search',[UserController::class,'search'])->name('user.search');

    Route::resource('blog',BlogController::class);
    Route::post('blog/search',[BlogController::class,'search'])->name('blog.search');

    Route::resource('template',TestTemplateController::class);
    Route::post('template/search',[TestTemplateController::class,'search'])->name('template.search');

    Route::resource('test',TestController::class);
    Route::post('test/search',[TestController::class,'search'])->name('test.search');
    Route::post('test/generate',[TestController::class,'generate'])->name('test.generate');
});
Route::get('admin/login',[AdminLoginController::class,'index'])->name('admin.index');
Route::get('admin/logout',[AdminLoginController::class,'logout'])->name('admin.logout');
Route::post('admin/login', [AdminLoginController::class, 'postLogin'])->name('admin.login');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [HomePageController::class, 'index'])->name('home');

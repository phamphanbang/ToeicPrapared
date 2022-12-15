<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\TestTemplateController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\HomePageController;
use App\Http\Controllers\User\TestController as UserTestController;
use App\Http\Controllers\User\BlogController as UserBlogController;
use App\Http\Controllers\User\InfoController as UserInfoController;

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
    Route::resource('user', UserController::class);
    Route::post('user/search', [UserController::class, 'search'])->name('user.search');

    Route::resource('blog', BlogController::class);
    Route::post('blog/search', [BlogController::class, 'search'])->name('blog.search');

    Route::resource('template', TestTemplateController::class);
    Route::post('template/search', [TestTemplateController::class, 'search'])->name('template.search');

    Route::resource('test', TestController::class);
    Route::post('test/search', [TestController::class, 'search'])->name('test.search');
    Route::post('test/generate', [TestController::class, 'generate'])->name('test.generate');
});
Route::get('admin/login', [AdminLoginController::class, 'index'])->name('admin.index');
Route::get('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
Route::post('admin/login', [AdminLoginController::class, 'postLogin'])->name('admin.login');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index'])->name('user.login');
Route::get('/registration', [LoginController::class, 'registration'])->name('user.registration');
Route::post('/login', [LoginController::class, 'login'])->name('user.login.post');
Route::post('/registration', [LoginController::class, 'register'])->name('user.registration.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('user.logout');

Route::get('/test', [UserTestController::class, 'index'])->name('user.test.index');
Route::get('/test/{type}', [UserTestController::class, 'type'])->name('user.test.type');
Route::post('/test/search', [UserTestController::class, 'search'])->name('user.test.search');
Route::get('/test/{id}/show', [UserTestController::class, 'show'])->name('user.test.show');

Route::get('/blog', [UserBlogController::class, 'index'])->name('user.blog.index');
Route::get('/blog/{id}', [UserBlogController::class, 'show'])->name('user.blog.show');
Route::post('/blog/search', [UserBlogController::class, 'search'])->name('user.blog.search');

Route::get('/security', [HomePageController::class, 'security'])->name('security');
Route::get('/contact', [HomePageController::class, 'contact'])->name('contact');
Route::get('/usage', [HomePageController::class, 'usage'])->name('usage');

Route::group(['middleware' => 'login'], function () {
    Route::get('/info/{id}', [UserInfoController::class, 'info'])->name('user.info.info');
    Route::put('/info/{id}', [UserInfoController::class, 'update'])->name('user.info.update');
    Route::get('/info/{id}/password', [UserInfoController::class, 'password'])->name('user.info.password');
    Route::put('/info/{id}/password', [UserInfoController::class, 'changePassword'])->name('user.info.changepass');
    Route::get('/info/{id}/history', [UserInfoController::class, 'history'])->name('user.info.history');
    Route::get('/info/{id}/plan', [UserInfoController::class, 'plan'])->name('user.info.plan');
    Route::post('/info/{id}/plan', [UserInfoController::class, 'createPlan'])->name('user.info.plan.create');
    Route::post('/info/{id}/plan/{pid}/update', [UserInfoController::class, 'updatePlan'])->name('user.info.plan.update');
    Route::delete('/info/{id}/plan/{pid}/delete', [UserInfoController::class, 'deletePlan'])->name('user.info.plan.delete');
    
    Route::get('/test/{id}/result/{result_id}', [UserTestController::class, 'result'])->name('user.test.result');
    Route::get('/test/{id}/result/{result_id}/details', [UserTestController::class, 'details'])->name('user.test.detail');
    Route::get('/test/{id}/start', [UserTestController::class, 'start'])->name('user.test.start');
    Route::post('/test/{id}/submit', [UserTestController::class, 'submit'])->name('user.test.submit');
    Route::post('/test/{id}/comment', [UserTestController::class, 'comment'])->name('user.test.comment');
    
    Route::post('/blog/comment', [UserBlogController::class, 'comment'])->name('user.blog.comment');
});

<?php

use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\TestController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Backend\NotificationsController;

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


## test pages ##
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/testvue', function () {
//     return view('frontend.pages.test.vuetest');
// });

//test page
// Route::resource('test', TestController::class);
// Route::delete('/deletemedia/{media_id}', [TestController::class, 'destroy_post_media'])->name('test.destroy.media');



Auth::routes(['verify' => true]);



// Route::get('/', function () {
//     return view('backend.pages.index');
// });

// Route::get('/backend/login', function () {
//     return view('backend.pages.forgot-password');
// });

// Route::get('/backend/register', function () {
//     return view('backend.pages.register');
// });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get("/", [IndexController::class, "index"])->name('/');

Route::get('/search', [IndexController::class, 'search'])->name('search');
Route::get('/category{slug}', [IndexController::class, 'category'])->name('category');
Route::get('/archive{data}', [IndexController::class, 'archive'])->name('archive');
Route::get('/author{username}', [IndexController::class, 'author'])->name('author');

Route::get('/contact-us', [IndexController::class, 'contact'])->name('contact');
Route::post('/contact-us', [IndexController::class, 'do_contact'])->name('do_contact');

Route::get('post/{post}', [IndexController::class, 'post_show'])->name('post.show');
Route::post('post/{post}', [IndexController::class, 'store_comment'])->name('post.add_comment');


Route::get('login/{provider}',                          [LoginController::class, 'redirectToProvider'])->name('social_login');
Route::get('login/{provider}/callback',                 [LoginController::class, 'handleProviderCallback'])->name('social_login_callback');


Route::group(['middleware' => 'verified'], function () {

    //dashboard
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    //user info
    Route::get('/edit-info', [UserController::class, 'edit_info'])->name('users.edit_info');
    Route::post('/edit-info', [UserController::class, 'update_info'])->name('users.update_info');
    Route::post('/edit-password', [UserController::class, 'update_password'])->name('users.update_password');

    //notifications users
    Route::any('user/notifications/get', [NotificationsController::class, 'getNotifications']);
    Route::any('user/notifications/read', [NotificationsController::class, 'markAsRead']);
    Route::any('user/notifications/read/{id}', [NotificationsController::class, 'markAsReadAndRedirect']);

    //post
    Route::get('/create-post', [UserController::class, 'create_post'])->name('post.create');
    Route::post('/create-post', [UserController::class, 'store_post'])->name('post.store');
    Route::get('/edit-post/{post_id}', [UserController::class, 'edit_post'])->name('post.edit');
    Route::put('/edit-post/{post_id}', [UserController::class, 'update_post'])->name('post.update');
    Route::delete('/delete-post/{post_id}', [UserController::class, 'destroy_post'])->name('post.destroy');
    // Route::get('/delete-post-media/{media_id}', [UserController::class, 'destroy_post_media'])->name('post.media.destroy');
    Route::post("/delete-post-media/{media_id}", [UserController::class,'destroy_post_media'])->name('post.media.destroy');

    //comments
    Route::get('/comments', [UserController::class, 'show_comments'])->name('comment.show');
    Route::get('/edit-comment/{comment_id}', [UserController::class, 'edit_comment'])->name('comment.edit');
    Route::put('/edit-comment/{comment_id}', [UserController::class, 'update_comment'])->name('comment.update');
    Route::delete('/delete-comment/{comment_id}', [UserController::class, 'destroy_comment'])->name('comment.destroy');
});












/*
//test send email by mailtrap
Route::get('send-mail', function () {
    $details = [
        'title' => 'title email',
        'body' => 'body email'
    ];
    Mail::to('testemail@gmail.com')->send(new MyTestMail($details));
    dd("Email is Sent.");
});
*/

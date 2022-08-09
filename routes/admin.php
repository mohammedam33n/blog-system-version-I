<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\PostsController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\ContactUsController;
use App\Http\Controllers\Backend\SupervisorsController;
use App\Http\Controllers\Backend\PostCommentsController;
use App\Http\Controllers\Backend\NotificationsController;
use App\Http\Controllers\Backend\PostCategoriesController;

// Admin Routes
Route::prefix("admin")->group(function () {



    Route::group(['middleware' => ['roles', 'role:admin|editor']], function () {


        //notifications admin
        Route::any('/notifications/get', [NotificationsController::class, 'getNotifications']);
        Route::any('/notifications/read', [NotificationsController::class, 'markAsRead']);
        Route::any('/notifications/read/{id}', [NotificationsController::class, 'markAsReadAndRedirect']);


        // Route::resource("/dashboard", AdminController::class);
        Route::resource("/", AdminController::class);

        
        Route::resource("/posts", PostsController::class);
        Route::post("/posts/removeImage/{media_id}", [PostsController::class, 'removeImage'])->name('posts.media.destroy');



        // Route::resource("/post_comments", PostCommentsController::class);
        // Route::resource("/post_categories", PostCategoriesController::class);

        Route::resource("/comments", PostCommentsController::class);
        Route::resource("/categories", PostCategoriesController::class);


        Route::resource("/pages", PagesController::class);
        Route::post('/pages/removeImage/{media_id}',    [PagesController::class, 'removeImage'])->name('pages.media.destroy');



        // Route::resource("/contact_us", ContactUsController::class);
        Route::resource("/contact", ContactUsController::class);

        Route::resource("/users", UsersController::class);
        Route::post('/users/removeImage',               [UsersController::class, 'removeImage'])->name('users.remove_image');



        Route::resource("/supervisor", SupervisorsController::class);
        Route::post('/supervisors/removeImage',         [SupervisorsController::class, 'removeImage'])->name('supervisors.remove_image');

        Route::resource("/settings", SettingsController::class);
    });
});

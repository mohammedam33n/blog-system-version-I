<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\CommentObserver;
use App\Observers\ContactObserver;
use App\Observers\PageObserver;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Category::observe(CategoryObserver::class);
        Post::observe(PostObserver::class);
        Page::observe(PageObserver::class);
        Comment::observe(CommentObserver::class);
        Contact::observe(ContactObserver::class);
        User::observe(UserObserver::class);
    }
}

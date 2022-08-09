<?php

namespace App\Http\Controllers\Backend;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Laratrust\Laratrust;

use App\Models\PostMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Create;
use App\Http\Requests\Post\Update;
use App\Http\Traits\Image\Delete;
use App\Http\Traits\Image\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    use Delete;
    use Upload;


    public function __construct()
    {
        if (\auth()->check()) {
            $this->middleware('auth');
        } else {
            return view('auth.login');
        }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {




        if (!\auth()->user()->ability('admin', 'manage_post_categories,show_post_categories')) {
            return redirect('admin');
        }


        $keyword = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $categoryId = (isset(\request()->category_id) && \request()->category_id != '') ? \request()->category_id : null;
        $status = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $sort_by = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'desc';
        $limit_by = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $posts = Post::with(['user', 'category', 'comments'])->wherePostType('post');
        if ($keyword != null) {
            $posts = $posts->search($keyword);
        }
        if ($categoryId != null) {
            $posts = $posts->whereCategoryId($categoryId);
        }
        if ($status != null) {
            $posts = $posts->whereStatus($status);
        }

        $posts = $posts->orderBy($sort_by, $order_by);
        $posts = $posts->paginate($limit_by);


        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');
        return view('backend.pages.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!\auth()->user()->ability('admin', 'create_posts')) {
            return redirect('admin');
        }

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');
        return view('backend.pages.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        if (!\auth()->user()->ability('admin', 'create_posts')) {
            return redirect('admin');
        }


        $post = auth()->user()->posts()->create($request->except('images'));

        if ($request->has('images')) {
            $this->uploadImage($request, Post::Post_PATH, $post);
        }



        if ($request->status == 1) {
            Cache::forget('recent_posts');
        }

        return redirect()->route('posts.index')->with(['message' => 'Post created successfully', 'alert-type' => 'success',]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if (!\auth()->user()->ability('admin', 'display_posts')) {
            return redirect('admin');
        }
        return view('backend.pages.posts.show', compact('post'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (!\auth()->user()->ability('admin', 'update_posts')) {
            return redirect('admin');
        }

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');
        return view('backend.pages.posts.edit', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, Post $post)
    {
        if (!\auth()->user()->ability('admin', 'update_posts')) {
            return redirect('admin');
        }

        if ($request->has('images')) {
            $this->uploadImage($request, Post::Post_PATH, $post);
        }
        $post->update($request->except('images'));

        return redirect()->route('posts.index')->with(['message' => 'Post updated successfully', 'alert-type' => 'success',]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (!\auth()->user()->ability('admin', 'delete_posts')) {
            return redirect('admin');
        }

        if ($post->media->count() > 0) {
            foreach ($post->media as $media) {
                $this->destroyImage(Post::Post_PATH . $media->file_name);
            }
        }
        $post->delete();

        return redirect()->route('posts.index')->with(['message' => 'Post deleted successfully', 'alert-type' => 'success',]);
    }


    public function removeImage(Request $request)
    {

        if (!\auth()->user()->ability('admin', 'delete_posts')) {
            return redirect('admin');
        }

        $media = PostMedia::whereId($request->media_id)->first();
        $this->destroyImage(Post::Post_PATH . $media->file_name);
        $media->delete();
        return true;
    }
}

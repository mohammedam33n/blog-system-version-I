<?php

namespace App\Http\Controllers\Backend;

use App\Models\Page;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Page\Create;
use App\Http\Requests\Page\Update;
use App\Http\Traits\Image\Delete;
use App\Http\Traits\Image\Upload;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
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

    public function index()
    {
        if (!\auth()->user()->ability('admin', 'manage_pages,show_pages')) {
            return redirect('admin');
        }

        $keyword = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $categoryId = (isset(\request()->category_id) && \request()->category_id != '') ? \request()->category_id : null;
        $status = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $sort_by = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'desc';
        $limit_by = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $pages = Page::wherePostType('page');
        if ($keyword != null) {
            $pages = $pages->search($keyword);
        }
        if ($categoryId != null) {
            $pages = $pages->whereCategoryId($categoryId);
        }
        if ($status != null) {
            $pages = $pages->whereStatus($status);
        }

        $pages = $pages->orderBy($sort_by, $order_by);
        $pages = $pages->paginate($limit_by);

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');
        return view('backend.pages.pages.index', compact('categories', 'pages'));
    }

    public function create()
    {
        if (!\auth()->user()->ability('admin', 'create_pages')) {
            return redirect('admin');
        }

        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');
        return view('backend.pages.pages.create', compact('categories'));
    }

    public function store(Create $request)
    {
        if (!\auth()->user()->ability('admin', 'create_pages')) {
            return redirect('admin');
        }


        $page = auth()->user()->posts()->create($request->except('images'));
        $this->uploadImage($request->images, Post::Post_PATH, $page);




        return redirect()->route('pages.index')->with(['message' => 'Page created successfully', 'alert-type' => 'success',]);
    }

    public function show(Page $page)
    {
        if (!\auth()->user()->ability('admin', 'display_pages')) {
            return redirect('admin');
        }
        return view('backend.pages.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        if (!\auth()->user()->ability('admin', 'update_pages')) {
            return redirect('admin');
        }
        $page->with(['media'])->wherePostType('page')->first();
        $categories = Category::orderBy('id', 'desc')->pluck('name', 'id');
        return view('backend.pages.pages.edit', compact('categories', 'page'));
    }

    public function update(Update $request, Page $page)
    {
        if (!\auth()->user()->ability('admin', 'update_pages')) {
            return redirect('admin');
        }

        $page->update($request->except('images'));
        $this->uploadImage($request->images, Post::Post_PATH, $page);


        return redirect()->route('pages.index')->with(['message' => 'Page updated successfully', 'alert-type' => 'success',]);
    }

    public function destroy(Page $page)
    {
        if (!\auth()->user()->ability('admin', 'delete_pages')) {
            return redirect('admin');
        }
        if ($page->media->count() > 0) {
            foreach ($page->media as $media) {
                if (File::exists('images/posts/' . $media->file_name)) {
                    unlink('images/posts/' . $media->file_name);
                }
            }
        }
        $page->delete();
        return redirect()->route('pages.index')->with(['message' => 'Page deleted successfully', 'alert-type' => 'success',]);
    }

    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('admin', 'delete_pages')) {
            return redirect('admin');
        }

        $media = PostMedia::whereId($request->media_id)->first();
        if ($media) {
            if (File::exists('images/posts/' . $media->file_name)) {
                unlink('images/posts/' . $media->file_name);
            }
            $media->delete();
            return true;
        }
        return false;
    }
}

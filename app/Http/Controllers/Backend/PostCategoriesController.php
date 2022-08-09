<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\Create;
use App\Http\Requests\Category\Update;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class PostCategoriesController extends Controller
{
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

        if (!\auth()->user()->ability('admin', 'manage_categories,show_categories')) {
            return redirect('admin');
        }

        $keyword = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $status = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $sort_by = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'desc';
        $limit_by = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $categories = Category::withCount('posts');

        if ($keyword != null) {
            $categories = $categories->search($keyword);
        }
        if ($status != null) {
            $categories = $categories->whereStatus($status);
        }

        $categories = $categories->orderBy($sort_by, $order_by);
        $categories = $categories->paginate($limit_by);

        return view('backend.pages.post_categories.index', compact('categories'));
    }

    public function create()
    {
        if (!\auth()->user()->ability('admin', 'create_categories')) {
            return redirect('admin');
        }

        return view('backend.pages.post_categories.create');
    }

    public function store(Create $request)
    {
        if (!\auth()->user()->ability('admin', 'create_categories')) {
            return redirect('admin');
        }

        Category::create($request->all());

        //add opserve
        if ($request->status == 1) {
            Cache::forget('global_categories');
        }

        return redirect()->route('categories.index')->with([
            'message' => 'Category created successfully',
            'alert-type' => 'success',
        ]);
    }


    public function edit(Category $category)
    {
        if (!\auth()->user()->ability('admin', 'update_categories')) {
            return redirect('admin');
        }

        return view('backend.pages.post_categories.edit', compact('category'));
    }

    public function update(Update $request, Category $category)
    {
        if (!\auth()->user()->ability('admin', 'update_categories')) {
            return redirect('admin');
        }

        $category->update($request->all());

        //add opserve
        Cache::forget('global_categories');
        return redirect()->route('categories.index')->with(['message' => 'Category updated successfully', 'alert-type' => 'success']);
    }

    public function destroy(Category $category)
    {
        if (!\auth()->user()->ability('admin', 'delete_categories')) {
            return redirect('admin');
        }


        foreach ($category->posts as $post) {
            if ($post->media->count() > 0) {
                foreach ($post->media as $media) {
                    if (File::exists('images/posts/' . $media->file_name)) {
                        unlink('images/posts/' . $media->file_name);
                    }
                }
            }
        }
        $category->delete();


        
        return redirect()->route('categories.index')->with(['message' => 'Category deleted successfully', 'alert-type' => 'success',]);
    }
}

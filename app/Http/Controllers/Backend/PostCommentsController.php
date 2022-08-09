<?php

namespace App\Http\Controllers\Backend;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\Update;
use Illuminate\Support\Facades\Cache;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class PostCommentsController extends Controller
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


        if (!\auth()->user()->ability('admin', 'manage_comments,show_comments')) {
            return redirect('admin');
        }

        $keyword = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $postId = (isset(\request()->post_id) && \request()->post_id != '') ? \request()->post_id : null;
        $status = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $sort_by = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'desc';
        $limit_by = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $comments = Comment::query();
        if ($keyword != null) {
            $comments = $comments->search($keyword);
        }
        if ($postId != null) {
            $comments = $comments->wherePostId($postId);
        }
        if ($status != null) {
            $comments = $comments->whereStatus($status);
        }

        $comments = $comments->orderBy($sort_by, $order_by);
        $comments = $comments->paginate($limit_by);

        $posts = Post::wherePostType('post')->pluck('title', 'id');
        return view('backend.pages.post_comments.index', compact('comments', 'posts'));
    }


    public function edit(Comment $comment)
    {
        if (!\auth()->user()->ability('admin', 'update_comments')) {
            return redirect('admin');
        }
        return view('backend.pages.post_comments.edit', compact('comment'));
    }

    public function update(Update $request, Comment $comment)
    {
        if (!\auth()->user()->ability('admin', 'update_comments')) {
            return redirect('admin');
        }
        $comment->update($request->all());
        Cache::forget('recent_comments');
        return redirect()->route('comments.index')->with(['message' => 'Comment updated successfully', 'alert-type' => 'success',]);
    }

    public function destroy(Comment $comment)
    {
        if (!\auth()->user()->ability('admin', 'delete_comments')) {
            return redirect('admin');
        }
        $comment->delete();
        return redirect()->back()->with(['message' => 'Comment deleted successfully', 'alert-type' => 'success',]);
    }
}

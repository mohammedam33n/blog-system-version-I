<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use App\Models\User;
use App\Models\Contact;
// use Illuminate\Http\Facades;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;
use App\Notifications\NewCommentForPostOwnerNotify;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {




        // dd('controller : -index');
        $posts = Post::with(['media', 'user'])
            ->whereHas('category', function ($query) {
                $query->whereStatus(1);
            })
            ->whereHas('user', function ($query) {
                $query->whereStatus(1);
            })
            ->post()->active()->orderBy('id', 'desc')->paginate(5);

        return view('frontend.pages.index', compact('posts'));
    }



    public function Search(Request $request)
    {
        // dd('controller : - Search');
        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword : null;
        $posts = Post::with(['media', 'user'])
            ->whereHas('category', function ($query) {
                $query->whereStatus(1);
            })
            ->whereHas('user', function ($query) {
                $query->whereStatus(1);
            });

        if ($keyword != null) {
            $posts = $posts->search($keyword, null, true);
        }

        // $posts = $posts->wherePostType('post')->whereStatus(1)->orderBy('id', 'desc')->paginate(5);
        $posts = $posts->post()->active()->orderBy('id', 'desc')->paginate(5);

        return view('frontend.pages.index', compact('posts'));
    }


    public function category($slug)
    {
        // dd('controller : - category');
        $category = Category::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first()->id;

        if ($category) {
            $posts = Post::with(['media', 'user'])
                ->whereCategoryId($category)
                ->post()
                ->active()
                ->orderBy('id', 'desc')
                ->paginate(5);


            return view('frontend.pages.index', compact('posts'));
        }


        return redirect()->route('frontend.index');
    }


    public function archive($data)
    {
        // dd('controller : - archive');
        $exploded_date = explode('-', $data);
        $month = $exploded_date[0];
        $year = $exploded_date[1];

        $posts = Post::with(['media', 'user'])
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->post()
            ->active()
            ->orderBy('id', 'desc')
            ->paginate(5);


        return view('frontend.pages.index', compact('posts'));
    }


    public function author($username)
    {
        // dd('controller : - author');
        $user = User::whereUsername($username)->whereStatus(1)->first()->id;
        $posts = Post::with(['media', 'user', 'category'])
            ->withCount('approved_comments')
            ->whereUserId($user)
            ->post()
            ->active()
            ->orderBy('id', 'desc')
            ->paginate(5);


        return view('frontend.pages.index', compact('posts'));
    }

    public function post_show($slug)
    {
        // dd('controller : - post_show  +' . $slug);
        $post = Post::with([
            'category', 'media', 'user',
            'approved_comments' => function ($query) {
                $query->orderBy('id', 'desc');
            }
        ]);

        $post = $post->whereHas('category', function ($query) {
            $query->whereStatus(1);
        })->whereHas('user', function ($query) {
            $query->whereStatus(1);
        });

        // $post = $post->whereSlug($slug)->firstOrFail();
        $post = $post->whereSlug($slug);
        $post = $post->active()->first();

        if ($post) {
            $blade = $post->post_type == 'post' ? 'post' : 'page';

            return view('frontend.pages.' . $blade, compact('post'));
        } else {
            return redirect()->route('/');
        }
    }

    public function store_comment(Request $request, $slug)
    {
        // dd('controller : - store_comment');
        $validation = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'url'       => 'nullable|url',
            'comment'   => 'required|min:10',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $post = Post::whereSlug($slug)->wherePostType('post')->whereStatus(1)->first();
        if ($post) {

            $userId = auth()->check() ? auth()->id() : null;
            $data['name']           = $request->name;
            $data['email']          = $request->email;
            $data['url']            = $request->url;
            $data['ip_address']     = $request->ip();
            $data['comment']        = Purify::clean($request->comment);
            $data['post_id']        = $post->id;
            $data['user_id']        = $userId;

            $comment = $post->comments()->create($data);

            // if (auth()->guest() || auth()->id() != $post->user_id) {
            //     $post->user->notify(new NewCommentForPostOwnerNotify($comment));
            // }

            // User::whereHas('roles', function ($query) {
            //     $query->whereIn('name', ['admin', 'editor']);
            // })->each(function ($admin, $key) use ($comment) {
            //     $admin->notify(new NewCommentForAdminNotify($comment));
            // });

            return redirect()->back()->with([
                'message' => 'Comment added successfully',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function contact()
    {
        // dd('controller : - contact');
        return view('frontend.pages.contact.index');
    }

    public function do_contact(Request $request)
    {
        // dd('controller : - do_contact');
        $validation = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'mobile'    => 'nullable|numeric',
            'title'     => 'required|min:5',
            'message'   => 'required|min:10',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $data['name']       = $request->name;
        $data['email']      = $request->email;
        $data['mobile']     = $request->mobile;
        $data['title']      = $request->title;
        $data['message']    = $request->message;

        Contact::create($data);

        return redirect()->back()->with([
            'message' => 'Message sent successfully',
            'alert-type' => 'success'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Create;
use App\Http\Requests\User\Update;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Image\Upload;
use App\Http\Traits\Image\Delete;

class UsersController extends Controller
{

    use Upload;
    use Delete;




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
        if (!\auth()->user()->ability('admin', 'manage_users,show_users')) {
            return redirect('admin/index');
        }




        $keyword = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $status = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $sort_by = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'desc';
        $limit_by = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';




        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        });
        $users =  User::with('roles.permissions', 'permissions');

        if ($keyword != null) {
            $users = $users->search($keyword);
        }
        if ($status != null) {
            $users = $users->whereStatus($status);
        }

        $users = $users->orderBy($sort_by, $order_by);
        $users = $users->paginate($limit_by);

        // dd($users);


        return view('backend.pages.users.index', compact('users'));
    }

    public function create()
    {
        if (!\auth()->user()->ability('admin', 'create_users')) {
            return redirect('admin/index');
        }
        return view('backend.pages.users.create');
    }

    public function store(Create $request)
    {
        if (!\auth()->user()->ability('admin', 'create_users')) {
            return redirect('admin/index');
        }

        // dd($request->all());

        if ($request->has('image')) {
            $this->uploadImage($request, User::User_PATH, $request);
        }
        // dd($request->except('image'));
        $user = User::create($request->except('image'));
        $user->attachRole(Role::whereName('user')->first()->id);

        return redirect()->route('users.index')->with(['message' => 'Users created successfully', 'alert-type' => 'success',]);
    }

    public function show(User $user)
    {
        if (!\auth()->user()->ability('admin', 'display_users')) {
            return redirect('admin/index');
        }

        return view('backend.pages.users.show', ['user' => $user->withCount('posts')->first()]);
    }

    public function edit(User $user)
    {
        if (!\auth()->user()->ability('admin', 'update_users')) {
            return redirect('admin/index');
        }

        return view('backend.pages.users.edit', compact('user'));
    }

    public function update(Update $request, User $user)
    {
        if (!\auth()->user()->ability('admin', 'update_users')) {
            return redirect('admin/index');
        }

        if ($request->has('image')) {
            if (isset($user->user_image)) {
                $this->destroyImage(User::User_PATH . $user->user_image);
            }
            $this->uploadImage($request, User::User_PATH, $user);
        }
        $user->update($request->except('image'));
        return redirect()->route('users.index')->with(['message' => 'User updated successfully', 'alert-type' => 'success',]);
    }

    public function destroy(User $user)
    {
        if (!\auth()->user()->ability('admin', 'delete_users')) {
            return redirect('admin/index');
        }

        if (isset($user->user_image)) {
            $this->destroyImage(User::User_PATH . $user->user_image);
        }
        $user->delete();
        return redirect()->route('users.index')->with(['message' => 'User deleted successfully', 'alert-type' => 'success',]);
    }

    public function removeImage(User $user)
    {
        if (!\auth()->user()->ability('admin', 'delete_users')) {
            return redirect('admin/index');
        }

        $user = User::whereId($request->user_id)->first();

        if ($user) {

            if (File::exists('assets/users/' . $user->user_image)) {
                unlink('assets/users/' . $user->user_image);
            }
            $user->user_image = null;
            $user->save();
            return 'true';
        }
        return 'false';
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        dd($provider, $socialUser);

        /*
        $token = $socialUser->token;
        $id = $socialUser->getId();
        $nickName = $socialUser->getNickname();
        $name = $socialUser->getName();
        $email = $socialUser->getEmail() == '' ? trim(Str::lower(Str::replaceArray(' ', ['_'], $name))) . '@' . $provider . '.com' : $socialUser->getEmail();
        $avatar = $socialUser->getAvatar();

        $user = User::firstOrCreate([
            'email' => $email
        ], [
            'name' => $name,
            'username' => $nickName != '' ? $nickName : trim(Str::lower(Str::replaceArray(' ', ['_'], $name))),
            'email' => $email,
            'email_verified_at' => Carbon::now(),
            'mobile' => $id,
            'status' => 1,
            'receive_email' => 1,
            'remember_token' => $token,
            'password' => Hash::make($email),
        ]);

        if ($user->user_image == '') {
            $filename = '' . $user->username . '.jpg';
            $path = public_path('/assets/users/' . $filename);
            Image::make($avatar)->save($path, 100);
            $user->update(['user_image' => $filename]);
        }
        $user->attachRole(Role::whereName('user')->first()->id);

        Auth::login($user, true);

        return redirect()->route('dashboard')->with([
            'message' => 'Logged in successfully',
            'alert-type' => 'success'
        ]);
        */
    }
}

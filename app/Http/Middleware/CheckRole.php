<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {


        $routeName = Route::getFacadeRoot()->current()->uri();
        $route = explode('/', $routeName);
        $roleRoutes = Role::distinct()->whereNotNull('name')->pluck('name')->toArray();

        if (auth()->check()) {


            if (!in_array($route[0], $roleRoutes)) {
                return $next($request);
            } else {

                if ($route[0] != auth()->user()->roles[0]->name) {

                    // return redirect()->route('/');
                    return $next($request);
                    // return redirect()->route('dashboard.index');

                } else {
                    return $next($request);
                }
            }
        } else {
            return redirect()->route('login');
        }






        // if (auth()->check()) {


        //     if (!in_array($route[0], $roleRoutes)) {
        //         return $next($request);
        //     } else {


        //         if ($route[0] != auth()->user()->roles[0]->allowed_route) {
        //             $path = $route[0] == auth()->user()->roles[0]->allowed_route ? $route[0].'.show_login_form' : '' . auth()->user()->roles[0]->allowed_route.'.index';
        //             return redirect()->route($path);
        //         } else {
        //             return $next($request);
        //         }

        //     }



        // } else {
        //     $routeDistination = in_array($route[0], $roleRoutes) ? $route[0].'.show_login_form' : 'user.show_login_form';
        //     $path = $route[0] != '' ? $routeDistination : auth()->user()->roles[0]->allowed_route.'.index';
        //     return redirect()->route($path);
        // }







    }
}

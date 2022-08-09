<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        if (!Auth::check()) {
            return redirect()->route('login');

        }
    }

    public function index()
    {
        if (Auth::check()) {
            return view('backend.pages.index');
        }
        return redirect()->route('login');
    }

}

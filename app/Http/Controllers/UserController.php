<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        return view('loginPage');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('home');
    }

    public function register()
    {
        return view('registerPage');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userAuth = Auth::user();
        if ($userAuth->id == 1) {
            return view('userListPage');
        } else {
            return to_route('home');
        }
    }
}

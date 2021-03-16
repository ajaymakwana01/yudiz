<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminAuthController extends Controller
{
    /**
     * show login page for admin
     */
    public function index()
    {
        return view('admin.login');
    }

    /**
     * login for api
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);


        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->with($request->only('email', 'remember'));
    }

    /**
     * Dashboard page for admin
     */
    public function dashboard()
    {
        return view('admin.home');
    }
}


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\User;
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
        //validate admin credential
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //attempt to login using auth
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('admin.dashboard');
        }

        //if fail to login or to validate return back with data
        return redirect()->back()->with($request->only('email', 'remember'));
    }

    /**
     * Dashboard page for admin
     */
    public function dashboard()
    {
        $users = new User();
        $orders = $users->getUserWithOrder();
        $product = new Product();
        $popularProduct = $product->getPopularProduct();
        return view('admin.home', compact('orders', 'popularProduct'));
    }

    /**
     * add product from admin table
     */
    public function addProduct(ProductRequest $request)
    {
        $product = new Product();
        if($product->addProduct($request)) {
            return redirect()->back()->with('message', 'Product added successfully!');
        } else {
            return redirect()->back()->with($request->only($request));
        }
    }
}


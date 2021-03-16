<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $proObj = new Product();
        $products = $proObj->getAllActiveProduct();
        return view('home', ['products' => $products]);
    }

    /**
     * add to cart function
     */
    public function addToCart(Request $request, $productId)
    {
        $userCart = null;
        $product = Product::find($productId);
        $userCart = json_decode($request->cookie('cart'));
        //here we check cart empty ot not. if it is empty we are adding first product to the cart
        if (empty($userCart)) {
            $userCart = [
                $productId => [
                    "name" => $product['product_name'],
                    "quantity" => 1,
                    "price" => $product['product_price'],
                ]
            ];
            $cookie = cookie('cart', json_encode($userCart), 365*24*60);
            return redirect()->back()->cookie($cookie)->with('success', 'Product added to cart successfully!');
        }

        // if cart has product then we are increasing the quantity of that product
        if(isset($userCart->$productId)) {
            $userCart->$productId->quantity++;
            $cookie = cookie('cart', json_encode($userCart), 365*24*60);
            return  redirect()->back()->cookie($cookie)->with('success', 'Product added to cart successfully!');
        }

        //here we are checking that another product has added in the cart?
        $userCart->$productId = [
                "name" => $product['product_name'],
                "quantity" => 1,
                "price" => $product['product_price'],
        ];
        $cookie = cookie('cart', json_encode($userCart), 365*24*60);
        return  redirect()->back()->cookie($cookie)->with('success', 'Product added to cart successfully!');
    }

    /**
     * Buy Product
     */
    public function buyNow(Request $request)
    {
        //we are grabing the cart data using cookie
        $cookieData = json_decode($request->cookie('cart'));
        $userData = Auth::user();
        if (empty($cookieData)) {
            return  redirect()->back()->with('Error', 'Your Cart is Empty please add product!');
        } else {
            $productCart = array();
            $key = 0;
            //creating an arry of product to add it in purchased order table
            foreach ($cookieData as $productId => $product) {
                $productCart[$key]['product_id'] = $productId;
                $productCart[$key]['user_id'] = $userData->id;
                $productCart[$key]['purchased_quantity'] = $product->quantity;
                $productCart[$key]['paid_amount'] = $product->quantity * $product->price;
                $productCart[$key]['created_at'] = Carbon::now();
                $productCart[$key]['updated_at'] = Carbon::now();

                $key++;
            }
            $order = new Order();
            $product = new Product();
            //adding the product into order table and reducing the quantity which was added earlier by admin.
            if ($order->checkOutOrder($productCart) && $product->updateQuantity($productCart)) {
                $cookie = Cookie::forget('cart');
               return redirect()->back()->cookie($cookie)->with('success', 'Purchase Successfull');
            } else {
                return redirect()->back()->with('Error', 'Faild to purchase!');
            }

        }

    }
}

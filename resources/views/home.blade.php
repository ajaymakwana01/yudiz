@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>

        <div class="col-md-8" style="margin-top:15px">
            <div class="card">
                <div class="card-header">{{ __('View Cart') }}</div>

                <div class="card-body">
                    @if (Cookie::get('cart'))
                        <table class="table table-condensed">
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                            </tr>
                            @php
                                $totalPrice = 0;
                            @endphp
                            @foreach (json_decode(Cookie::get('cart')) as $item)
                                <tr>
                                    <th>{{ $item->name }}</th>
                                    <th>{{ $item->quantity }}</th>
                                    <th>{{ $item->price * $item->quantity }}</th>
                                    @php
                                        $totalPrice = $totalPrice + $item->price * $item->quantity;
                                    @endphp
                                </tr>
                            @endforeach
                        </table>
                        <form action="{{ route('checkout') }}" method="post">
                            @csrf
                            <input type="submit" value="Pay Now {{$totalPrice}}" class="btn btn-primary" style="margin-left: 60%"/>
                        </form>
                    @else
                        <div class="card-header">{{ __('Your Cart is Empty!') }}</div>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-md-8" style="margin-top:15px">
            <div class="card">
                <div class="card-header">{{ __('All Products') }}</div>
                <div class="card-body">
                    <table class="table table-condensed">
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($products as $product)
                            <tr>
                                    <th>{{ $product['product_name'] }}</th>
                                    <th>{{ $product['product_price'] }}</th>
                                    <th>
                                        <form action="{{ route('product.addToCart', ['productId' => $product['id']]) }}" name="yourForm" id="$product['id']" method="post">
                                            @csrf
                                            <input type="submit" value="Add to Cart" class="btn btn-primary" />
                                        </form>
                                    </th>
                                </form>
                            </tr>
                        @endforeach
                        {{ $products->links() }}
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

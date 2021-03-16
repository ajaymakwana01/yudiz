@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>{{ __('Admin Dashboard') }}</strong></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <strong>{{ __('You are logged in as Admin!') }}</strong>
                </div>
            </div>

            <div class="card" style="margin-top: 15px">
                <div class="card-header"><strong>{{ __('Add Product') }}</strong></div>

                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-primary" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.addproduct') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="productName" class="col-md-4 col-form-label text-md-right">{{ __('Product Name') }}</label>

                            <div class="col-md-6">
                                <input id="productName" type="text" class="form-control @error('productName') is-invalid @enderror" name="productName" value="{{ old('productName') }}" required autocomplete="productName" autofocus>

                                @error('productName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="quantity" class="col-md-4 col-form-label text-md-right">{{ __('Product Quantity') }}</label>

                            <div class="col-md-6">
                                <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity"  value="{{ old('quantity') }}" required autocomplete="quantity">

                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" required autocomplete="price">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Product Status') }}</label>

                            <div class="col-md-6">
                                <div class="radio">
                                <label><input type="radio" name="status" value="1" checked> Active</label>
                                <label><input type="radio" name="status" value="0">Deactive</label>
                                </div>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add Product') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card" style="margin-top: 15px">
                <div class="card-header"><strong>{{ __('Order History') }}</strong></div>
                @if (!empty($orders))
                <div class="container">
                    <div class="row">
                        @foreach ($orders as $user)
                            <div class="card col" style="width: 18rem, margin:15px;">
                                <div class="card-header">
                                    {{$user['name']}}
                                </div>
                                <ul class="list-inline list-group list-group-flush" style="margin-top: 15px">
                                    @php
                                        $totalBill = 0;
                                    @endphp
                                    @foreach ($user['order'] as $product)
                                        <li class=" list-inline-item list-group-item"><strong>{{ $product['product_name'] }} {{$product['pivot']['purchased_quantity']}} * {{$product['pivot']['paid_amount']}}</strong></li>
                                        @php
                                            $totalBill = $totalBill + $product['pivot']['paid_amount'];
                                        @endphp
                                    @endforeach
                                </ul>
                                <div class="card-header">
                                    <strong>Total Bill: </strong>{{$totalBill}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                    <strong>{{ __('Noone hase purchased anything') }}</strong>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

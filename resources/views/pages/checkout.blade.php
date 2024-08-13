@extends('layouts.master')
@section('title', 'Checkout')
@section('content')
    <header class="page-header">
        <h1>Checkout</h1>
        <h3 class="cart-amount">Grand Total: {{ \App\Models\Cart::totalAmount(session()->get('cart', [])) }}</h3>
    </header>

    <main class="checkout-page">
        <div class="container">
            <div class="checkout-form">
                <form action="" id="payment-form" method="post">
                    @csrf
                    <div class="field">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="@error('name') has-error @enderror" placeholder="Your Name" value="{{ old('name') ? old('name') : auth()->user()->name }}">
                        @error('name')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="name">Email</label>
                        <input type="email" name="email" id="email" class="@error('email') has-error @enderror" placeholder="xyz@abc.com" value="{{ old('email') ? old('email') : auth()->user()->email }}">
                        @error('email')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="name">Phone</label>
                        <input type="phone" name="phone" id="phone" class="@error('phone') has-error @enderror" placeholder="+00 99110022" value="{{ old('phone') ? old('phone') : auth()->user()->phone }}">
                        @error('phone')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="name">Country</label>
                        <select name="country" id="country">
                            <option value="Pakistan">Pakistan</option>
                            <option value="China">China</option>
                            <option value="India">India</option>
                            <option value="Bangladesh">Bangladesh</option>
                        </select>
                        @error('country')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="state">State</label>
                        <input type="text" name="state" id="state" class="@error('state') has-error @enderror" placeholder="Your State" value="{{ old('state')}}">
                        @error('state')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field">
                    <label for="name">City</label>
                    <input type="text" name="city" id="city" class="@error('city') has-error @enderror" placeholder="Your City" value="{{ old('city') }}">
                    @error('city')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                    </div>

                    <div class="field">
                        <label for="name">Address</label>
                        <input type="text" name="address" id="address" class="@error('address') has-error @enderror" placeholder="Your Address" value="{{ old('address') }}">
                        @error('address')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>

@endsection

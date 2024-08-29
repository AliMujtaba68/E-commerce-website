@extends('layouts.master')
@section('title', 'Cart')
@section('content')
    <header class="page-header">
        <h1>Order Succesfully Placed!</h1>
    </header>

    <section class="page-success">
        <div class="container">
            <h2>Your Order Has Been succesfully placed</h1>
            <h3>Your order ID is: {{$order->id}}</h2>
        </div>
    </section>

@endsection

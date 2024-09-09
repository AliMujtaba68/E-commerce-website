@extends('layouts.master')
@section('title', 'Home Page')
@section('content')
    <main class="homepage">

        @include('pages.components.home.header')

        <!-- Carousel Section -->
        <section class="carousel-section">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100 carousel-image" src="{{ asset('img/products/bf0.png') }}" alt="First slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Gear Up for Greatness: Your Ultimate Sports Store</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 carousel-image" src="{{ asset('img/products/bf1.jpg') }}" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 carousel-image" src="{{ asset('img/products/bf2.jpg') }}" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </section>

        <section class="products-section">
            <div class="container">
                <h1 class="section-title">Featured Products</h1>
                <div class="products-row">
                    @foreach ($products as $product)
                        <x-product-box :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection

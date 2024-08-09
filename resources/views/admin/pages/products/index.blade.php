@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <h1 class="page-title">PRODUCTS</h1>
    <div class="container">
        <div class="text-end mb-3">
            <a href="{{ route('adminpanel.products.create') }}" class="btn btn-primary mb-3">+ Create Product</a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Products</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Colors</th>
                                    <th>Image</th>
                                    <th>Published</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="productTableBody">
                                @foreach($products as $product)
                                    <tr id="product-{{ $product->id }}">
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>
                                            @foreach ($product->colors as $color)
                                                <span class="badge color-badge" data-color="{{$color->code}}" style="background: {{$color->code}}">{{$color->name}}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="height: 40px;">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>{{ $product->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>
                                            <a href="{{ route('adminpanel.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm deleteProductBtn" data-id="{{ $product->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .badge-outline {
            border: 1px solid #000;
            color: #000;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteButtons = document.querySelectorAll('.deleteProductBtn');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var productId = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this product?')) {
                        fetch(`/adminpanel/products/${productId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.querySelector(`#product-${productId}`).remove();
                                alert('Product deleted successfully.');
                            } else {
                                alert('Failed to delete product.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    }
                });
            });

            adjustBadgeOutline();
        });

        function adjustBadgeOutline() {
            const colorBadges = document.querySelectorAll('.color-badge');
            colorBadges.forEach(badge => {
                const bgColor = badge.getAttribute('data-color');
                if (bgColor === '#ffffff' || bgColor.toLowerCase() === 'white') {
                    badge.classList.add('badge-outline');
                }
            });
        }
    </script>
@endsection

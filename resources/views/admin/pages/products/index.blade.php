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
                            <tbody id="categoryTableBody">
                                @foreach($products as $product)
                                    <tr id="product-{{ $product->id }}">
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>
                                            @foreach ($product->colors as $color)
                                                <span class="badge" style="background: {{$color->code}}">{{$color->name}}</span>
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

    <script>
function attachDeleteEvent() {
    var deleteButtons = document.querySelectorAll('.deleteCategoryBtn');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var row = this.closest('tr');
            var categoryId = row.getAttribute('data-id');

            if (confirm('Are you sure you want to delete this category?')) {
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/adminpanel/categories/${categoryId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (response.ok) {
                        row.remove();
                        displayFlashMessage('Category deleted successfully.', 'success');
                    } else {
                        response.json().then(data => {
                            console.error('Error:', response.status, data.message || data.error);
                            alert('Failed to delete category: ' + (data.message || data.error));
                        });
                    }
                })
                .catch(error => {
                    console.error('Network error:', error);
                    alert('A network error occurred.');
                });
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    attachDeleteEvent();
});

function displayFlashMessage(message, type) {
    var alertDiv = document.createElement('div');
    alertDiv.classList.add('alert', `alert-${type}`);
    alertDiv.textContent = message;

    var container = document.querySelector('.container');
    container.insertBefore(alertDiv, container.firstChild);

    setTimeout(function() {
        alertDiv.remove();
    }, 3000);
}

    </script>
@endsection

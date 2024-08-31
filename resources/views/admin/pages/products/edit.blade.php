@extends('layouts.admin')

@section('title', 'Products')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 5px; /* Adjust this value to match the height of your navbar */
        }
        .page-title {
            text-align: center;
            margin-bottom: 2rem;
        }
        .centered-card {
            max-width: 800px;
            margin: 0 auto;
        }
        .btn-back {
            margin-bottom: 1rem;
        }
        #messageArea {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            transition: opacity 0.5s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row mb-3">
            <div class="col-12 text-start">
                <a href="{{ route('adminpanel.products') }}" class="btn btn-primary mb-3">+ back to Product page</a>
            </div>
        </div>
        <h1 class="page-title">Edit Product</h1>
        <div class="row justify-content-center mb-5">
            <div class="col-12">
                <div class="card centered-card">
                    <div class="card-header">
                        <h5>Edit Product</h5>
                    </div>
                    <div class="card-body">
                        <form id="editProductForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{$product->title}}">
                                        @error('title')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price">Price</label>
                                        <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price / 100) }}">
                                        @error('price')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select name="category_id" id="category-id" class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">-- SELECT CATEGORY --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{$product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                                        @error('image')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <img src="{{asset('storage/' .$product->image)}}" width="80px" height="80px">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="colors">Colors</label> &nbsp; &nbsp;
                                        @foreach ($colors as $color)
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="colors[]" class="form-check-input" value="{{ $color->id }}" {{ in_array($color->id, old('colors', $product->colors->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <label for="{{ $color->name }}" class="form-check-label">{{ $color->name }}</label>
                                            </div>
                                        @endforeach
                                        @error('colors')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Describe your product">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-end">
                                <button type="button" class="btn btn-primary" id="submitBtn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="messageArea" class="alert alert-success d-none" role="alert"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitButton = document.getElementById('submitBtn');
            const form = document.getElementById('editProductForm');

            submitButton.addEventListener('click', function() {
                submitForm();
            });

            function submitForm() {
                const formData = new FormData(form);
                fetch(`{{ route('adminpanel.products.update', $product->id) }}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const messageArea = document.getElementById('messageArea');
                    if (data.success) {
                        messageArea.innerText = 'Product updated successfully!';
                        messageArea.classList.remove('d-none');
                        setTimeout(() => {
                            window.location.href = `{{ route('adminpanel.products') }}`;
                        }, 2000); // Redirect after 2 seconds
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    </script>
</body>
</html>

@endsection

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
            padding-top: 70px;
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
                                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $product->title }}">
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
                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                        <label for="subcategory">Subcategory</label>
                                        <select name="subcategory_id" id="subcategory-id" class="form-control @error('subcategory_id') is-invalid @enderror">
                                            <option value="">-- SELECT SUBCATEGORY --</option>
                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}" data-category-id="{{ $subcategory->category_id }}" {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('subcategory_id')
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
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                                        @error('image')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <img src="{{ asset('storage/' . $product->image) }}" width="80px" height="80px">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="colors">Colors</label>
                                        @foreach ($colors as $color)
                                            <div class="form-check">
                                                <input type="checkbox" name="colors[]" value="{{ $color->id }}" class="form-check-input" id="color{{ $color->id }}" {{ in_array($color->id, old('colors', $product->colors->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="color{{ $color->id }}">{{ $color->name }}</label>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#category-id').on('change', function() {
                var categoryId = $(this).val();
                $('#subcategory-id option').each(function() {
                    var subcategoryCategoryId = $(this).data('category-id');
                    if (subcategoryCategoryId == categoryId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('#subcategory-id').val(''); // Reset subcategory selection
            });

            // Trigger the change event to ensure correct display of subcategories on page load
            $('#category-id').trigger('change');

            $('#submitBtn').on('click', function() {
                var formData = new FormData($('#editProductForm')[0]);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('adminpanel.products.update', $product->id) }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '{{ route('adminpanel.products') }}';
                        } else {
                            console.error('Error:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Product</title>
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
        <h1 class="page-title">Create Product</h1>
        <div class="row justify-content-center mb-5">
            <div class="col-12">
                <div class="card centered-card">
                    <div class="card-header">
                        <h5>Create Product</h5>
                    </div>
                    <div class="card-body">
                        <form id="createProductForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror">
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
                                        <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror">
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
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                <option value="{{ $subcategory->id }}" data-category-id="{{ $subcategory->category_id }}">{{ $subcategory->name }}</option>
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
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="colors">Colors</label>
                                        @foreach ($colors as $color)
                                            <div class="form-check">
                                                <input type="checkbox" name="colors[]" value="{{ $color->id }}" class="form-check-input" id="color{{ $color->id }}">
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
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                                @error('description')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="flash-message" class="alert d-none mt-3"></div>
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

            $('#createProductForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('adminpanel.products.store') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#flash-message').removeClass('d-none alert-danger').addClass('alert-success').text('Product created successfully.').fadeIn();
                            setTimeout(function() {
                                $('#flash-message').fadeOut().addClass('d-none');
                            }, 3000);
                            $('#createProductForm')[0].reset();
                        } else {
                            $('#flash-message').removeClass('d-none alert-success').addClass('alert-danger').text(response.message).fadeIn();
                            setTimeout(function() {
                                $('#flash-message').fadeOut().addClass('d-none');
                            }, 3000);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#flash-message').removeClass('d-none alert-success').addClass('alert-danger').text('An error occurred: ' + error).fadeIn();
                        setTimeout(function() {
                            $('#flash-message').fadeOut().addClass('d-none');
                        }, 3000);
                    }
                });
            });
        });
    </script>
</body>
</html>

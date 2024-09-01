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

        .alert {
            display: none;
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
                        <form id="createProductForm" action="{{ route('adminpanel.products.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" id="title" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}">
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
                                        <input type="number" id="price" name="price"
                                            class="form-control @error('price') is-invalid @enderror"
                                            value="{{ old('price') }}">
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
                                        <select name="category_id" id="category-id"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">-- SELECT CATEGORY --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
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
                                        <input type="file" name="image" id="image"
                                            class="form-control @error('image') is-invalid @enderror">
                                        @error('image')
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
                                        <label for="colors">Colors</label> &nbsp; &nbsp;
                                        @foreach ($colors as $color)
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="colors[]" class="form-check-input"
                                                    value="{{ $color->id }}">
                                                <label for="{{ $color->name }}"
                                                    class="form-check-label">{{ $color->name }}</label>
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
                                        <textarea name="description" id="description"
                                            class="form-control @error('description') is-invalid @enderror" rows="5"
                                            placeholder="Describe your product">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-end">
                                <button type="button" class="btn btn-primary" id="submitBtn">Create</button>
                            </div>
                        </form>
                        <div id="successMessage" class="alert alert-success mt-3" role="alert">
                            Product successfully created.
                        </div>
                        <div id="errorMessage" class="alert alert-danger mt-3" role="alert">
                            Something went wrong. Please try again.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitButton = document.getElementById('submitBtn');
            const form = document.getElementById('createProductForm');
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');

            if (submitButton && form) {
                submitButton.addEventListener('click', function() {
                    submitForm();
                });
            }

            function submitForm() {
                const formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        successMessage.classList.remove('d-none');
                        successMessage.style.display = 'block'; // Show the success message
                        errorMessage.style.display = 'none'; // Hide the error message if previously shown
                        setTimeout(() => {
                            window.location.href = `{{ route('adminpanel.products') }}`;
                        }, 2000);
                    } else {
                        errorMessage.textContent = data.message || 'An unexpected error occurred.';
                        errorMessage.classList.remove('d-none');
                        errorMessage.style.display = 'block'; // Show the error message
                        successMessage.style.display = 'none'; // Hide the success message if previously shown
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    errorMessage.textContent = 'An unexpected error occurred. Please try again.';
                    errorMessage.classList.remove('d-none');
                    errorMessage.style.display = 'block'; // Show the error message
                    successMessage.style.display = 'none'; // Hide the success message if previously shown
                });
            }
        });
    </script>
</body>

</html>

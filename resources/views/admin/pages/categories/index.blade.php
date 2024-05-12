@extends('layouts.admin')
@section('title', 'Category')
@section('content')
    <h1 class="page-title">Categories</h1>
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-6 offset-md-3">
                <div class="card-header">
                    <h5>Create Category</h5>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control">
                            <div id="name-error" class="invalid-feedback" style="display: none;"></div>
                        </div>
                        
                        <div class="form-group text-end">
                            <button type="button" id="createCategoryBtn" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        
    document.getElementById('createCategoryBtn').addEventListener('click', function() {
        // Get the value of the name field
        
        console.log('Name:', name, 'CSRF Token:', csrfToken);
        var name = document.getElementById('name').value;

        // Clear previous error message
        document.getElementById('name-error').innerText = '';
        document.getElementById('name-error').style.display = 'none';

        // Perform basic client-side validation
        if (name.trim() === '') {
            document.getElementById('name-error').innerText = 'Name is required.';
            document.getElementById('name-error').style.display = 'block';
            return;
        }

        // Get CSRF token value from the meta tag
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Make an AJAX request to call the store function
        var xhr = new XMLHttpRequest();
        xhr.open('POST', "{{ route('adminpanel.category.store') }}", true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Include CSRF token in the request headers
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Success response
                console.log(xhr.responseText);
                // Redirect or perform any other action as needed
            } else {
                // Error response
                console.error(xhr.responseText);
            }
        };
        xhr.onerror = function() {
            // Network error
            console.error('Network error occurred.');
        };
        xhr.send(JSON.stringify({ name: name }));
    });
</script>

@endsection

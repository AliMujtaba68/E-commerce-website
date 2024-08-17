@extends('layouts.admin')

@section('title', 'Subcategories')

@section('content')

    <h1 class="page-title">Subcategories</h1>

    <div class="container">

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success" id="flash-message">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" id="flash-message">
                {{ session('error') }}
            </div>
        @endif
        <div class="col-12 text-start">
            <a href="{{ route('adminpanel.categories') }}" class="btn btn-primary mb-3">+ back to Category page</a>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 offset-md-3">
                <div class="card-header">
                    <h5>Create Subcategory</h5>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control">
                            <div id="name-error" class="invalid-feedback" style="display: none;"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="category">Category</label>
                            <select id="category" class="form-control">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div id="category-error" class="invalid-feedback" style="display: none;"></div>
                        </div>
                        <div class="form-group text-end">
                            <button type="button" id="createSubcategoryBtn" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Subcategories</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="subcategoryTableBody">
                                @foreach($subcategories as $subcategory)
                                    <tr data-id="{{ $subcategory->id }}">
                                        <td>{{ $subcategory->id }}</td>
                                        <td>{{ $subcategory->name }}</td>
                                        <td>{{ $subcategory->category->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm deleteSubcategoryBtn">Delete</button>
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
        document.getElementById('createSubcategoryBtn').addEventListener('click', function() {
            var name = document.getElementById('name').value;
            var categoryId = document.getElementById('category').value;

            document.getElementById('name-error').innerText = '';
            document.getElementById('name-error').style.display = 'none';
            document.getElementById('category-error').innerText = '';
            document.getElementById('category-error').style.display = 'none';

            if (name.trim() === '') {
                document.getElementById('name-error').innerText = 'Name is required.';
                document.getElementById('name-error').style.display = 'block';
                return;
            }

            if (categoryId.trim() === '') {
                document.getElementById('category-error').innerText = 'Category is required.';
                document.getElementById('category-error').style.display = 'block';
                return;
            }

            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            var xhr = new XMLHttpRequest();
            xhr.open('POST', "{{ route('adminpanel.subcategory.store') }}", true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

            xhr.onload = function() {
                if (xhr.status === 201) {
                    var responseData = JSON.parse(xhr.responseText);

                    var subcategoryTableBody = document.getElementById('subcategoryTableBody');
                    var newRow = document.createElement('tr');
                    newRow.setAttribute('data-id', responseData.id);

                    newRow.innerHTML = `
                        <td>${responseData.id}</td>
                        <td>${responseData.name}</td>
                        <td>${responseData.category_name}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm deleteSubcategoryBtn">Delete</button>
                        </td>
                    `;

                    subcategoryTableBody.appendChild(newRow);
                    document.getElementById('name').value = '';
                    document.getElementById('category').value = '';

                    attachDeleteEvent();
                    displayFlashMessage('Subcategory added successfully.', 'success');
                } else if (xhr.status === 422) {
                    var errors = JSON.parse(xhr.responseText);
                    if (errors.name) {
                        document.getElementById('name-error').innerText = errors.name[0];
                        document.getElementById('name-error').style.display = 'block';
                    }
                    if (errors.category_id) {
                        document.getElementById('category-error').innerText = errors.category_id[0];
                        document.getElementById('category-error').style.display = 'block';
                    }
                } else {
                    displayFlashMessage('Error adding subcategory.', 'error');
                }
            };

            xhr.send(JSON.stringify({ name: name, category_id: categoryId }));
        });

        function attachDeleteEvent() {
            var deleteButtons = document.querySelectorAll('.deleteSubcategoryBtn');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var row = button.closest('tr');
                    var subcategoryId = row.getAttribute('data-id');
                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    var xhr = new XMLHttpRequest();
                    xhr.open('DELETE', "{{ url('adminpanel/subcategories/') }}/" + subcategoryId, true);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            row.remove();
                            displayFlashMessage('Subcategory deleted successfully.', 'success');
                        } else {
                            displayFlashMessage('Error deleting subcategory.', 'error');
                        }
                    };

                    xhr.send();
                });
            });
        }

        function displayFlashMessage(message, type) {
            var flashMessage = document.createElement('div');
            flashMessage.className = 'alert alert-' + type;
            flashMessage.innerText = message;

            var container = document.querySelector('.container');
            container.insertBefore(flashMessage, container.firstChild);

            setTimeout(function() {
                flashMessage.remove();
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            attachDeleteEvent();
        });
    </script>

@endsection

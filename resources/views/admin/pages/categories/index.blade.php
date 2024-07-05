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

        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-header">

                        <h5>Categories</h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-stripped">

                            <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>Name</th>

                                    <th>Total Products</th>

                                    <th>Published</th>

                                    <th>Actions</th>

                                </tr>

                            </thead>

                            <tbody id="categoryTableBody">

                                @foreach($categories as $category)

                                    <tr data-id="{{$category->id}}">

                                        <td>{{$category->id}}</td>

                                        <td>{{$category->name}}</td>

                                        <td>-</td>

                                        <td>{{ \Carbon\Carbon::parse($category->created_at)->format('Y-m-d H:i:s') }}</td>

                                        <td>

                                            <a href="#" class="btn btn-primary btn-sm">Edit</a>

                                            <button type="button" class="btn btn-danger btn-sm deleteCategoryBtn">Delete</button>

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

        document.getElementById('createCategoryBtn').addEventListener('click', function() {

            var name = document.getElementById('name').value;

            document.getElementById('name-error').innerText = '';

            document.getElementById('name-error').style.display = 'none';

            if (name.trim() === '') {

                document.getElementById('name-error').innerText = 'Name is required.';

                document.getElementById('name-error').style.display = 'block';

                return;

            }

            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            var xhr = new XMLHttpRequest();

            xhr.open('POST', "{{ route('adminpanel.category.store') }}", true);

            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

            xhr.onload = function() {

                if (xhr.status === 201) {

                    var responseData = JSON.parse(xhr.responseText);

                    var categoryTableBody = document.getElementById('categoryTableBody');

                    var newRow = document.createElement('tr');

                    newRow.setAttribute('data-id', responseData.id);

                    var createdAt = new Date(responseData.created_at);

                    var formattedDate = createdAt.getFullYear() + '-' + 
                                        ('0' + (createdAt.getMonth() + 1)).slice(-2) + '-' + 
                                        ('0' + createdAt.getDate()).slice(-2) + ' ' + 
                                        ('0' + createdAt.getHours()).slice(-2) + ':' + 
                                        ('0' + createdAt.getMinutes()).slice(-2) + ':' + 
                                        ('0' + createdAt.getSeconds()).slice(-2);

                    newRow.innerHTML = `

                        <td>${responseData.id}</td>

                        <td>${responseData.name}</td>

                        <td>-</td>

                        <td>${formattedDate}</td>

                        <td>

                            <a href="#" class="btn btn-primary btn-sm">Edit</a>

                            <button type="button" class="btn btn-danger btn-sm deleteCategoryBtn">Delete</button>

                        </td>

                    `;

                    categoryTableBody.appendChild(newRow);

                    document.getElementById('name').value = '';

                    attachDeleteEvent();

                } else if (xhr.status === 422) {

                    var errorResponse = JSON.parse(xhr.responseText);

                    if (errorResponse.error && errorResponse.error.name) {

                        document.getElementById('name-error').innerText = errorResponse.error.name[0];

                        document.getElementById('name-error').style.display = 'block';

                    }

                } else {

                    console.error('Error:', xhr.responseText);

                }

            };

            xhr.onerror = function() {

                console.error('Network error occurred.');

            };

            xhr.send(JSON.stringify({ name: name }));

        });

        function attachDeleteEvent() {

            var deleteButtons = document.querySelectorAll('.deleteCategoryBtn');

            deleteButtons.forEach(function(button) {

                button.addEventListener('click', function() {

                    var row = this.closest('tr');

                    var categoryId = row.getAttribute('data-id');

                    if (confirm('Are you sure you want to delete this category?')) {

                        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        fetch(`/adminpanel/categories/${categoryId}`, { // Corrected URL

                            method: 'DELETE',

                            headers: {

                                'Content-Type': 'application/json',

                                'X-CSRF-TOKEN': csrfToken

                            }

                        })

                        .then(response => {

                            if (response.ok) {

                                row.remove();

                            } else {

                                // Enhanced error handling

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

    </script>

@endsection

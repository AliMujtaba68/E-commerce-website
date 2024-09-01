@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid dashboard-container">
        <h1 class="page-title">Admin Dashboard</h1>
        <div class="row stats-cards">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Total Orders</h2>
                        <p class="card-text" id="totalOrders">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Pending Orders</h2>
                        <p class="card-text" id="pendingOrders">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Proccesing Orders</h2>
                        <p class="card-text" id="processingOrders">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Shipped Orders</h2>
                        <p class="card-text" id="shippedOrders">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Completed Orders</h2>
                        <p class="card-text" id="completedOrders">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Declined Orders</h2>
                        <p class="card-text" id="declinedOrders">0</p>
                    </div>
                </div>
            </div>
            <!-- Add other cards similarly -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route('adminpanel.dashboard.data') }}')
                .then(response => response.json())
                .then(data => {
                    console.log('Dashboard Data:', data); // Log the data
                    document.getElementById('totalOrders').innerText = data.totalOrders;
                    document.getElementById('completedOrders').innerText = data.completedOrders;
                    document.getElementById('shippedOrders').innerText = data.shippedOrders;
                    document.getElementById('processingOrders').innerText = data.processingOrders;
                    document.getElementById('declinedOrders').innerText = data.declinedOrders;
                    document.getElementById('pendingOrders').innerText = data.pendingOrders;
                })
                .catch(error => console.error('Error fetching dashboard data:', error));
        });
    </script>
@endsection

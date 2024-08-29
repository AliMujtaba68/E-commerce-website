@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid dashboard-container">
        <h1 class="page-title">Dashboard</h1>
        <p class="welcome-message">Welcome to the admin dashboard</p>
        <div class="row stats-cards">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Total Sales</h2>
                        <p class="card-text">$50,000</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Orders</h2>
                        <p class="card-text">1,200</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Users</h2>
                        <p class="card-text">3,400</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

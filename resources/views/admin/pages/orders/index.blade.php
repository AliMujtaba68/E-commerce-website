@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <h1 class="page-title">Orders</h1>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Orders</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>By</th>
                                    <th>Item</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="productTableBody">
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->items->count() }}</td>
                                        <td>${{ $order->total }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/y') }}</td>
                                        <td>
                                            @if($order->status == 'Pending')
                                                <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                                            @elseif($order->status == 'Processing')
                                                <span class="badge bg-info">{{ $order->status }}</span>
                                            @elseif($order->status == 'Shipped')
                                                <span class="badge bg-primary">{{ $order->status }}</span>
                                            @elseif($order->status == 'Completed')
                                                <span class="badge bg-success">{{ $order->status }}</span>
                                            @elseif($order->status == 'Declined')
                                                <span class="badge bg-danger">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('adminpanel.orders.view', $order->id) }}" class="btn btn-warning">View</a>
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

    <style>
        .badge-outline {
            border: 1px solid #000;
            color: #000;
        }
    </style>
@endsection

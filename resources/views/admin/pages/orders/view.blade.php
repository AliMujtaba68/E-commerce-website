@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
    <div class="page-title">Order #{{ $order->id }}</div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Order Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>Order Id</td>
                                    <td>{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        <div style="display: flex; gap: 15px; max-width: 300px;">
                                            <select name="status" class="form-control" id="status-select">
                                                @foreach ($states as $status)
                                                    <option value="{{ $status }}" @if($order->status == $status) selected @endif>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-success" id="update-status-btn">Update</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Amount</td>
                                    <td>${{ $order->total }}</td>
                                </tr>
                                <tr>
                                    <td>User</td>
                                    <td>{{ $order->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $order->email }}</td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>{{ $order->phone }}</td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td>{{ $order->country }}</td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td>{{ $order->state }}</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>{{ $order->city }}</td>
                                </tr>
                                <tr>
                                    <td>Zip Code</td>
                                    <td>{{ $order->zip }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{ $order->address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#update-status-btn').click(function(event) {
                event.preventDefault(); // Prevent default button behavior

                var selectedStatus = $('#status-select').val();
                var token = $('meta[name="csrf-token"]').attr('content');
                var orderId = '{{ $order->id }}';

                $.ajax({
                    url: '{{ route('adminpanel.orders.status.update', $order->id) }}',
                    method: 'POST',
                    data: {
                        status: selectedStatus,
                        _token: token
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Order status updated successfully.');
                        } else {
                            alert('Failed to update order status.');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handling various types of errors
                        if (xhr.status === 419) {
                            alert('CSRF token expired. Please refresh the page and try again.');
                        } else if (xhr.status === 401) {
                            alert('Unauthorized. Please log in.');
                        } else {
                            alert('An error occurred: ' + xhr.statusText);
                        }
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endsection

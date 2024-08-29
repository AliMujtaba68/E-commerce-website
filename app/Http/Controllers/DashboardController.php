<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function getData()
    {
        $data = [
            'totalOrders' => Order::count(),
            'completedOrders' => Order::where('status', 'completed')->count(),
            'shippedOrders' => Order::where('status', 'shipped')->count(),
            'processingOrders' => Order::where('status', 'processing')->count(),
            'declinedOrders' => Order::where('status', 'declined')->count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
        ];

        return response()->json($data);
    }
}

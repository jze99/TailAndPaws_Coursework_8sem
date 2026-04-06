<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariation;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalUsers' => User::count(),
            'totalProducts' => ProductVariation::count(),
            'totalOrders' => Order::count(),
            'recentOrders' => Order::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'popularProducts' => OrderItem::popular(10)->get(),
            'monthlyRevenue' => Order::getMonthlyRevenue(),

        ];
        return view('admin.dashboard', $data);
    }
}

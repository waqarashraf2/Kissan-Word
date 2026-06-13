<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Magazine;
use App\Models\Order;
use App\Models\Product;
use App\Models\Video;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'counts' => [
                'products' => Product::count(),
                'orders' => Order::count(),
                'blogs' => Blog::count(),
                'videos' => Video::count(),
                'magazines' => Magazine::count(),
                'inquiries' => Contact::where('status', 'new')->count(),
            ],
            'recentOrders' => Order::latest()->take(8)->get(),
        ]);
    }
}

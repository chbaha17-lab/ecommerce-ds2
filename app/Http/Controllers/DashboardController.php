<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'productsCount' => Product::count(),
            'categoriesCount' => Category::count(),
        ]);
    }
}
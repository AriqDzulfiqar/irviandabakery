<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardProductController extends Controller
{
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::with(['galleries','category'])
                    ->where('users_id', Auth::user()->id)
                    ->get();
        return view('pages.dashboard-products',[
            'products' => $products
        ]);
    }

    public function details()
    {
        return view('pages.dashboard-products-details');
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.dashboard-products-create',[
            'categories' => $categories
        ]);
    }
}

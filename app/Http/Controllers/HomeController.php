<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('front.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('front.products.show', compact('product'));
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->active()->latest()->limit(8)->get();
        return view('front.home' , compact('products'));
    }
}

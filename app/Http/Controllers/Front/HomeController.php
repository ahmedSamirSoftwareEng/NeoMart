<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $storeIds = User::whereNotNull('store_id')->distinct('store_id')->pluck('store_id');
        $products = Product::with('category')->whereIn('store_id', $storeIds)->active()->latest()->limit(8)->get();
        return view('front.home', compact('products'));
    }
}

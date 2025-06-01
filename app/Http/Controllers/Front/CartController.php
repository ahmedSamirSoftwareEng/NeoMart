<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }
    public function index()
    {
        return view('front.cart', [
            'cart' => $this->cart,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|numeric|min:1',
        ]);
        $product = Product::find($request->product_id);
        $this->cart->add($product, $request->quantity);
        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);
        $this->cart->update($id, $request->quantity);
    }

    public function destroy($id)
    {
        $this->cart->delete($id);
    }
}

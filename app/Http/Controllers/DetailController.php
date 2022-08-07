<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class DetailController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {
        $product = Product::with(['galleries', 'user'])->where('slug', $id)->firstOrFail();

        return view('pages.detail', [
            'product' => $product
        ]);
    }

    public function add(Request $request, $id)
    {

        $cart = Cart::where('products_id', $id)->where('users_id', Auth::user()->id);

        if ($cart->count()) {
            $cart->increment('quantity', $request->quantity);
            $cart = $cart->first();
        } else {
            $data = [
                'products_id' => $id,
                'users_id' => Auth::user()->id,
                'quantity' => $request->quantity
            ];

            Cart::create($data);
        }

        return redirect()->route('cart');
    }
}

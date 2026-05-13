<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = session()->get('keranjang', []);

        return view('keranjang.sidebar', compact('keranjang'));
    }

    public function add(Product $product)
    {
        $keranjang = session()->get('keranjang', []);
        if(isset($keranjang[$product->id])) {
            $keranjang[$product->id]['qty']++;
        } else {
            $keranjang[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'qty' => 1
            ];
        }

        session()->put('keranjang', $keranjang);
        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function remove($id)
    {
        $keranjang = session()->get('keranjang', []);

        unset($keranjang[$id]);

        session()->put('keranjang', $keranjang);

        return back();
    }

    public function update(Request $request, $id)
{
    $cart = session()->get('keranjang', []);

    if(isset($cart[$id])) {

        $cart[$id]['qty'] += $request->change;

        if($cart[$id]['qty'] <= 0) {
            unset($cart[$id]);
        }

        session()->put('keranjang', $cart);

        $subtotal = isset($cart[$id])
            ? $cart[$id]['price'] * $cart[$id]['qty']
            : 0;

        $total = 0;

        foreach($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }

    return response()->json([
        'success' => false
    ]);
}
}

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
        if ($product->stock <= 0) {
            return back()->with('error', 'Stok produk habis');
        }

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$product->id])) {

            // Cegah qty melebihi stok
            if ($keranjang[$product->id]['qty'] >= $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi');
            }

            $keranjang[$product->id]['qty']++;
        } else {

            $keranjang[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'rental_price' => $product->rental_price,
                'image' => $product->image,
                'qty' => 1,
            ];
        }

        session()->put('keranjang', $keranjang);

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function remove($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);

            session()->put('keranjang', $keranjang);
        }

        return back()->with('success', 'Produk dihapus dari keranjang');
    }

    public function update(Request $request, $id)
    {
        $change = (int) $request->change;

        $cart = session()->get('keranjang', []);

        if (!isset($cart[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan di keranjang'
            ]);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ]);
        }

        if ($change > 0) {

            $currentQty = $cart[$id]['qty'];

            // Jangan sampai qty melebihi stok database
            if (($currentQty + $change) > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi'
                ]);
            }

            $cart[$id]['qty'] += $change;
        }

        elseif ($change < 0) {

            $cart[$id]['qty'] -= abs($change);

            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }
        }

        session()->put('keranjang', $cart);

        $subtotal = 0;

        if (isset($cart[$id])) {
            $subtotal = $cart[$id]['price'] * $cart[$id]['qty'];
        }

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }
}
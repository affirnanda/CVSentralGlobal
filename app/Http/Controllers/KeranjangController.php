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

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ], [
            'qty.required' => 'Silahkan isi jumlah produk yang ingin dipesan',
            'qty.integer' => 'Silahkan isi jumlah produk yang ingin dipesan',
            'qty.min' => 'Silahkan isi jumlah produk yang ingin dipesan',
        ]);

        $qty = (int) $validated['qty'];

        if ($product->stock <= 0) {
            return back()->with('error', 'Stok produk habis');
        }

        if ($qty > $product->stock) {
            return back()->with('error', 'Stok barang tidak mencukupi');
        }

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$product->id])) {
            $newQty = $keranjang[$product->id]['qty'] + $qty;

            if ($newQty > $product->stock) {
                return back()->with('error', 'Stok barang tidak mencukupi');
            }

            $keranjang[$product->id]['qty'] = $newQty;
        } else {
            $keranjang[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'rental_price' => $product->rental_price,
                'image' => $product->image,
                'qty' => $qty,
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
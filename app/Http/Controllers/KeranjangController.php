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
            $keranjang[$product->id]['qty']++;
        } else {
            $keranjang[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'rental_price' => $product->rental_price,
                'image' => $product->image,
                'qty' => 1
            ];
        }

        // decrement stock
        $product->stock = max(0, $product->stock - 1);
        $product->save();

        session()->put('keranjang', $keranjang);
        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function remove($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            $qty = $keranjang[$id]['qty'];

            // restore stock
            $product = Product::find($id);
            if ($product) {
                $product->stock += $qty;
                $product->save();
            }

            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
        }

        return back();
    }

    public function update(Request $request, $id)
    {
        $change = intval($request->change);
        $cart = session()->get('keranjang', []);

        if (!isset($cart[$id])) {
            return response()->json(['success' => false]);
        }

        $product = Product::find($id);

        if ($change > 0) {
            // Attempt to increase qty in cart: require available stock
            if (!$product || $product->stock < $change) {
                return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi']);
            }

            $product->stock -= $change;
            $product->save();

            $cart[$id]['qty'] += $change;
        } elseif ($change < 0) {
            // Decrease qty in cart and restore stock
            $restore = abs($change);
            $cart[$id]['qty'] -= $restore;

            if ($product) {
                $product->stock += $restore;
                $product->save();
            }

            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }
        }

        session()->put('keranjang', $cart);

        $subtotal = isset($cart[$id]) ? $cart[$id]['price'] * $cart[$id]['qty'] : 0;

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

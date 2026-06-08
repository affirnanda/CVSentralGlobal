<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function buyForm()
    {
        $keranjang = session()->get('keranjang', []);
        if (count($keranjang) === 0) {
        return back()->with('error', 'Keranjang kosong');
    }
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        return view('checkout.buy', compact(
            'keranjang',
            'paymentMethods'
        ));
    }

    public function rentForm()
    {
        $keranjang = session()->get('keranjang', []);
        if (count($keranjang) === 0) {
        return back()->with('error', 'Keranjang kosong');
    }
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        return view('checkout.rent', compact(
            'keranjang',
            'paymentMethods'
        ));
    }

    public function process(Request $request)
{
    $request->validate([
        'type' => 'required|in:buy,rent',
        'full_name' => 'required|string|max:100',
        'email' => 'required|email',
        'phone' => 'required|numeric|digits_between:9,13',
        'province' => 'required',
        'city' => 'required',
        'district' => 'required',
        'address'=> 'required|max:200',
        'postal_code' => 'required',
        'payment_method_id' => 'required|exists:payment_methods,id',
        'rent_start' => 'required_if:type,rent|date',
        'rent_end' => 'required_if:type,rent|date|after:rent_start',
    ], [
        'full_name.required' => 'Silahkan input nama anda',
        'full_name.max' => 'input nama terlalu panjang',
        'email.required' => 'Silahkan input email anda',
        'email.email' => 'Format email anda salah',
        'phone.required' => 'Silahkan input nomor whatsapp anda',
        'phone.digits_between' => 'nomor WA tidak valid',
        'province.required' => 'Silahkan pilih provinsi anda',
        'city.required' => 'Silahkan pilih kota anda',
        'district.required' => 'Silahkan pilih kecamatan anda',
        'address.required' => 'Silahkan input alamat pengiriman anda',
        'address.max' => 'Input alamat terlalu panjang',
        'postal_code.required' => 'Silahkan input kode pos anda',
        'payment_method_id.required' => 'Silahkan pilih metode pembayaran anda',
        'rent_start.required_if' => 'Silahkan pilih tanggal mulai sewa anda',
        'rent_end.required_if' => 'Silahkan pilih tanggal akhir sewa anda',
        'rent_end.after' => 'Tanggal akhir harus setelah tanggal mulai',
    ]);

    $cart = session()->get('keranjang', []);
    if (empty($cart)) {
        return back()->with('error', 'Keranjang kosong');
    }

    $days = 1;
    if ($request->type == 'rent') {
        $days = \Carbon\Carbon::parse($request->rent_start)
            ->diffInDays(\Carbon\Carbon::parse($request->rent_end));
    }
    
    $total = 0;
    foreach ($cart as $item) {
        if ($request->type == 'rent') {
            $total += $item['rental_price'] * $item['qty'] * $days;
        } else {
            $total += $item['price'] * $item['qty'];
        }
    }

    return DB::transaction(function () use ($request, $cart, $days, $total) {
        
        // 1. Buat Order
        $order = Order::create([
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'type' => $request->type,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'address'=> $request->address,
            'postal_code' => $request->postal_code,
            'rent_start' => $request->rent_start,
            'rent_end' => $request->rent_end,
            'payment_method_id' => $request->payment_method_id,
            'total' => $total,
        ]);

        foreach ($cart as $item) {
            if ($request->type == 'rent') {
                $price = $item['rental_price'];
                $subtotal = $price * $item['qty'] * $days;
            } else {
                $price = $item['price'];
                $subtotal = $price * $item['qty'];
            }
            
            OrderItem::create([ 
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'price' => $price,
                'qty' => $item['qty'],
                'subtotal' => $subtotal,
            ]);

            $product = Product::find($item['id']);
            if ($product && $product->stock < $item['qty']) {
                throw new \Exception("Stok untuk produk {$product->name} tidak mencukupi.");
            }
        }

        session()->forget('keranjang');

        return redirect()->route('invoice.show', $order)->with('success', 'Order berhasil dibuat!');
    });
}

    public function invoice(Order $order)
    {
        $order->load('items', 'paymentMethod');
        return view('checkout.invoice', compact('order'));
    }
}
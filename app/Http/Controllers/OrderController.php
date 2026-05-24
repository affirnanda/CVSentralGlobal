<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::latest();

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'paymentMethod');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
    $request->validate([
        'status' => 'required|in:pending,paid,rejected'
    ]);

    $order->update([
        'status' => $request->status
    ]);

    return back()->with(
        'success',
        'Status pesanan berhasil diperbarui'
    );
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

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
        if (in_array($order->status, ['paid', 'rejected'])) {

            return back()->with(
                'error',
                'Status order yang sudah Paid atau Rejected tidak dapat diubah lagi.'
            );
        }

        $request->validate([
            'status' => 'required|in:pending,paid,rejected'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->load('items.product');

        if ($oldStatus !== 'rejected' && $newStatus === 'rejected') {
            $this->returnStock($order);
        }

        $order->update([
            'status' => $newStatus
        ]);

        return back()->with(
            'success',
            'Status pesanan berhasil diperbarui'
        );
    }

    private function returnStock(Order $order)
    {
        foreach ($order->items as $item) {

            if (!$item->stock_returned && $item->product) {

                $item->product->increment('stock', $item->qty);

                $item->update([
                    'stock_returned' => true
                ]);
            }
        }
    }

    public function updateReturnStatus(Request $request, Order $order)
    {
        $request->validate([
            'return_status' => 'required|in:not_returned,returned'
        ]);

        $order->load('items.product');

        if ($request->return_status == 'returned') {

            foreach ($order->items as $item) {

                if (!$item->stock_returned && $item->product) {

                    $item->product->increment('stock', $item->qty);

                    $item->update([
                        'stock_returned' => true
                    ]);
                }
            }
        }

        $order->update([
            'return_status' => $request->return_status
        ]);

        return back()->with(
            'success',
            'Status pengembalian berhasil diperbarui'
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
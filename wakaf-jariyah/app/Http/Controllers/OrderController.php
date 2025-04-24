<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('user.donation', compact('orders'));
    }

    public function indexAdmin()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.order', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'gender' => 'required|in:L,P',
            'phone' => 'required|string',
            'notes' => 'nullable|string',
            'item' => 'required|string',
            'amount' => 'required|numeric|min:1000',
        ]);

        try {
            Order::create($validated);

            // Redirect back with a success message
            // return redirect()->back()->with('success', 'Donasi berhasil dikirim!');
            return redirect()->route('user.transfer')->with('success', 'Donasi berhasil terbuat!');

        } catch (\Exception $e) {
            // Handle any error that may occur during the creation
            return redirect()->back()->with('error', 'Terjadi kesalahan, coba lagi.');
        }
    }

    public function updateStatus(Order $order)
    {
        try {
            $order->status = 'paid';
            $order->checked_by = auth()->user()->name;
            $order->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Status order berhasil diperbarui.');
        } catch (\Exception $e) {
            // Handle any error that may occur during the creation
            return redirect()->back()->with('error', 'Terjadi kesalahan, coba lagi.');
        }
    }
}

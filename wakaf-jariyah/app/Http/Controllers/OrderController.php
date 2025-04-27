<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Status;
use App\API\DuitkuAPI;
use Exception;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        /* $orders = Order::latest()->get(); */
        $duitku = new DuitkuAPI();
        $payment_methods = $duitku->getPaymentMethods();

        return view('user.donation', [
            'payment_methods' => $payment_methods,
        ]);
    }

    public function indexTransfer(Request $request, $uuid){
        $order = Order::where('uuid', $uuid)->first();

        return view('user.transfer', [
            'order' => $order,
        ]);
    }

    public function indexAdmin()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.order', compact('orders'));
    }

    public function store(Request $request)
    {
        /* try { */
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'gender' => 'required|in:L,P',
                'phone' => 'required|string',
                'notes' => 'nullable|string',
                'item' => 'required|string',
                'amount' => 'required|numeric|min:1000',
                'payment_method' => 'required|string',
                'payment_name' => 'required|string',
            ]);

            $input = $request->all();
            $duitku = new DuitkuAPI();
            $uuid = md5(microtime());
            $new_id = ''; 
            $order_id = 'WKF-' . date('Ymd') . '-0000';

            $payload = [
                'paymentAmount' => (int)$input['amount'],
                'paymentMethod' => $input['payment_method'],
                'merchantOrderId' => $order_id,
                'customerVaName' => $input['name'],
                'email' => $input['email'],
                'productDetails' => 'Pembelian ' . $input['item'],
                'itemDetails' => [
                    [
                        'name' => $input['item'],
                        'price' => $input['amount'],
                        'quantity' => 1,
                    ]
                ],
                'callbackUrl' => url("donation/callback"),
                'returnUrl' => url("donation/$uuid")
            ];

            // Send the payment creation request to the Duitku API
            $result = $duitku->createInvoice($payload);

            // Throw an exception if the API response is invalid or return null
            if (!$result) {
                throw new Exception();
            }


            Order::create([
                ...$validated,
                'status_id' => 2, //2 == Pending
                'uuid' => $uuid,
                'reference' => $result['reference'],
                'order_id' => $order_id,
                'payment_url' => $result['paymentUrl']
            ]);

            // Redirect back with a success message
            // return redirect()->back()->with('success', 'Donasi berhasil dikirim!');
            return redirect('donation/' . $uuid)->with('success', 'Donasi berhasil terbuat!');
        /* } catch (\Exception $e) {
            // Handle any error that may occur during the creation
            return redirect()->back()->with('error', 'Terjadi kesalahan, coba lagi.');
        } */
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

    public function handleCallback(Request $request)
    {
        $order_id = $request->get('merchantOrderId');
        $duitkuAPI = new DuitkuAPI();
        $password = Str::random(8); // Generate a random password (8 characters).
        $status_id = 3; // 3 == Failed

        // Check the transaction status using the Duitku API.
        $result = $duitkuAPI->transactionStatus($order_id);

        // Map the API status code to the internal status.
        if ($result['statusCode'] == '00') {
            $status_id = 1; // 1 == Success
        }
        if ($result['statusCode'] == '01') {
            $status_id = 2; // 2 == Pending
        }

        Order::where('reference', $result['reference'])
            ->update([
                'status_id' => $status_id,
                'payment_url' => '',
            ]);
    }
}

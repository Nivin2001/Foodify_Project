<?php

namespace App\Http\Controllers\API\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Services\PaymentService;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $service) {}

    /**
     * إنشاء عملية دفع جديدة
     */
   public function pay(PaymentRequest $request)
{
    $order = Order::findOrFail($request->order_id);

    if ($order->status === 'paid') {
        return response()->json([
            'message' => 'This order is already paid.',
        ], 400);
    }
    $paymentIntent = $this->service->payWithStripe($order);

    $payment = $order->payments()
        ->where('transaction_id', $paymentIntent->id)
        ->first();

    return response()->json([
        'message' => 'Payment initiated successfully',
        'payment' => new PaymentResource($payment),
        'client_secret' => $paymentIntent->client_secret,
    ]);
}

    /**
     * تأكيد الدفع
     */
    public function confirmPayment(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|string',
        ]);
        
        $payment = $this->service->confirmStripePayment($request->transaction_id);

        if (!$payment) {
            return response()->json([
                'message' => 'Payment not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Payment confirmed successfully',
            'data'    => new PaymentResource($payment),
        ]);
    }
}

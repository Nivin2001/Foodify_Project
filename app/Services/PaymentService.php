<?php

namespace App\Services;

use App\Repositories\PaymentRepository;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Payment;

class PaymentService
{
    public function __construct(private PaymentRepository $repo)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * إنشاء أو استرجاع PaymentIntent
     */
    public function payWithStripe($order): PaymentIntent
    {
        if ($order->payment_status === 'paid') {
            throw new \Exception('This order is already paid');
        }

        $existingPayment = Payment::where('order_id', $order->id)
            ->where('payment_status', 'pending')
            ->first();

        if ($existingPayment) {
            return PaymentIntent::retrieve($existingPayment->transaction_id);
        }

        $paymentIntent = PaymentIntent::create([
            'amount' => $order->total * 100,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'stripe',
            'payment_status' => 'pending',
            'transaction_id' => $paymentIntent->id,
        ]);

        return $paymentIntent;
    }


    public function confirmStripePayment(string $transactionId): ?Payment
    {
        $payment = Payment::where('transaction_id', $transactionId)->first();

        if (! $payment) {
            return null;
        }
        if ($payment->payment_status === 'paid') {
            return $payment;
        }
        $payment->payment_status = 'paid';
        $payment->save();
        
        $order = $payment->order;
        $order->status = 'paid';
        $order->save();

        return $payment;
    }
}

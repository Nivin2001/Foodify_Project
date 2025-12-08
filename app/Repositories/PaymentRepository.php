<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository
{
    public function create(array $data): Payment
    {
        return Payment::create($data);
    }

    public function updateStatus(int $paymentId, string $status, ?string $transactionId = null)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->payment_status = $status;
        $payment->transaction_id = $transactionId;
        $payment->save();

        return $payment;
    }
}

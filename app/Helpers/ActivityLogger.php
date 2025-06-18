<?php

namespace App\Helpers;

use App\Models\AdminActivity;
use Carbon\Carbon;

class ActivityLogger
{
    public static function log($type, $description)
    {
        AdminActivity::create([
            'user_id'     => auth()->id(),
            'activity_type' => $type,
            'description' => $description,
            'created_at' => Carbon::now('Asia/Kolkata'), // Indian time
        ]);
    }

    // Optional short functions for important actions:
    public static function paymentAdded($payment, $enquiry)
    {
        $name = "{$enquiry->first_name} {$enquiry->surname}";
        $class = $enquiry->admission_for;
        $amount = number_format($payment->amount_paid, 2);
        $mode = $payment->payment_mode;

        self::log('Payment Added', "💰 ₹{$amount} paid by {$name} ({$class}) via {$mode}");
    }

    public static function paymentUpdated($payment, $enquiry)
    {
        $name = "{$enquiry->first_name} {$enquiry->surname}";
        $class = $enquiry->admission_for;
        $amount = number_format($payment->amount_paid, 2);

        self::log('Payment Updated', "🔁 Payment updated to ₹{$amount} for {$name} ({$class})");
    }

    public static function totalFeeSet($enquiry)
    {
        $name = "{$enquiry->first_name} {$enquiry->surname}";
        $class = $enquiry->admission_for;
        $amount = number_format($enquiry->total_amount, 2);

        self::log('Total Fee Set', "🧾 Total fee set to ₹{$amount} for {$name} ({$class})");
    }
}

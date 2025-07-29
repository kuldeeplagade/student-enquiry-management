<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Models\Payment;
use App\Helpers\ActivityLogger;

class PaymentController extends Controller
{
    public function index($id)
    {
        $enquiry = Enquiry::with('payments')->findOrFail($id);
        return view('dashboard.payments.index', compact('enquiry'));
    }

    public function create($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        return view('dashboard.payments.create', compact('enquiry'));
    }

    //Add payment 
    public function store(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);

        // Step 1: Validate input
        $request->validate([
            'payment_mode' => 'required|string',
            'amount_paid' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);

        // Step 2: Ensure final_fee is set if default_fee exists and final_fee is null
        if (!is_null($enquiry->default_fee) && is_null($enquiry->final_fee)) {
            $enquiry->final_fee = $enquiry->default_fee;
            $enquiry->save();

            // Optional log entry for tracking when auto final_fee is set
            ActivityLogger::log(
                'Final Fee Auto Set',
                'Final fee set to default fee ₹' . $enquiry->default_fee . ' for ' . $enquiry->first_name . ' ' . $enquiry->last_name
            );
        }

        // Step 3: Prevent overpayment
        $total = $enquiry->final_fee ?? $enquiry->default_fee ?? 0;
        $paid = $enquiry->payments->sum('amount_paid');
        $newPayment = $request->amount_paid;

        if ($total > 0 && ($paid + $newPayment) > $total) {
            return back()->with('error', 'Payment exceeds payable fee!');
        }

        // Step 4: Save the payment
        $payment = Payment::create([
            'enquiry_id'   => $enquiry->id,
            'payment_mode' => $request->payment_mode,
            'user_id'      => auth()->id(),
            'amount_paid'  => $newPayment,
            'notes'        => $request->notes,
        ]);

        // Step 5: Log the activity
        $class  = $enquiry->admission_for ?? 'Class Not Set';
        $name   = $enquiry->first_name . ' ' . $enquiry->last_name;
        $amount = number_format($payment->amount_paid, 2);
        $mode   = $payment->payment_mode;

        ActivityLogger::log(
            'Payment Added',
            "₹{$amount} paid by {$name} ({$class}) via {$mode}"
        );

        return redirect()->route('payments.index', $enquiry->id)->with('success', 'Payment recorded successfully.');
    }

    //Set Discount ammount
    public function setDiscount(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);

        $request->validate([
            'discount_amount' => 'nullable|numeric|min:0|max:100000'
        ]);

        $discount = $request->discount_amount ?? 0;
        $default = $enquiry->default_fee ?? 0;

        $final = max(0, $default - $discount); // prevent negative values

        $enquiry->discount_amount = $discount;
        $enquiry->final_fee = $final;
        $enquiry->save();

        // Activity Log
        ActivityLogger::log(
            'Discount Updated',
            "Discount of ₹{$discount} set for {$enquiry->first_name} {$enquiry->last_name} ({$enquiry->admission_for}), Final Payable Fee: ₹{$final}"
        );

        return back()->with('success', 'Discount updated successfully.');
    }

}


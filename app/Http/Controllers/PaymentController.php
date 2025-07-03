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

    public function store(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);

        $request->validate([
            'payment_mode' => 'required|string',
            'amount_paid' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
            'total_amount' => 'nullable|numeric|min:1'
        ]);

        //  Add a flag to check if we're setting it first time
        $feeJustSet = false;

        //  Only set total amount if it's null
        if (is_null($enquiry->total_amount) && $request->filled('total_amount')) {
            $enquiry->total_amount = $request->input('total_amount');
            $enquiry->save();
            $feeJustSet = true;
        }

        //  Log only if it was just set
        if ($feeJustSet) {
            $class = $enquiry->admission_for ?? 'Class Not Set';
            ActivityLogger::log(
                'Total Fee Set',
                '🎯 Total fee of ₹' . $enquiry->total_amount . ' set for ' . $enquiry->first_name . ' ' . $enquiry->last_name . ' (' . $class . ')'
            );
        }

        // Check for overpayment
        $total = $enquiry->total_amount ?? 0;
        $paid = $enquiry->payments->sum('amount_paid');
        $newPayment = $request->amount_paid;

        if ($total > 0 && ($paid + $newPayment) > $total) {
            return back()->with('error', ' Payment exceeds total fee!');
        }

        // Store new payment
        Payment::create([
            'enquiry_id' => $enquiry->id,
            'payment_mode' => $request->payment_mode,
            'user_id' => auth()->id(),
            'amount_paid' => $newPayment,
            'notes' => $request->notes,
        ]);

        // Log Payment Added activity (inline format)
        $payment = $enquiry->payments()->latest()->first();
        $class = $enquiry->admission_for ?? 'Class Not Set';
        $name = $enquiry->first_name . ' ' . $enquiry->last_name;
        $amount = number_format($payment->amount_paid, 2);
        $mode = $payment->payment_mode;

        ActivityLogger::log(
            'Payment Added',
            "💰 ₹{$amount} paid by {$name} ({$class}) via {$mode}"
        );

        return redirect()->route('payments.index', $enquiry->id)->with('success', ' Payment recorded successfully.');
    }

}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Models\Payment;
use App\Models\Expense;
use Carbon\Carbon;

class ReportsController extends Controller
{
    //Revenue Related Report
    public function revenue(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        // Fix fallback logic
        if ($year && !$month) {
            // Year selected, all months
            $startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $endDate = Carbon::createFromDate($year, 12, 31)->endOfYear();
        } elseif ($year && $month) {
            // Both selected
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        } else {
            // Default to current month/year
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $year = $startDate->year;
            $month = $startDate->month;
        }


        // Filter enquiries created in the selected range
        $query = Enquiry::with(['payments' => function ($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate]);
        }])->whereBetween('created_at', [$startDate, $endDate]);

        // Filters
        if ($request->filled('branch_name')) {
            $query->where('branch_name', $request->branch_name);
        }

        if ($request->filled('admission_for')) {
            $query->where('admission_for', $request->admission_for);
        }

        if ($request->filled('student_name')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->student_name . '%')
                    ->orWhere('surname', 'like', '%' . $request->student_name . '%');
            });
        }

        // $enquiries = $query->get();
        $enquiries = $query->paginate(10);

        // Calculate totals
        $totalFinalFee = $enquiries->sum(fn($e) => $e->final_fee ?? $e->default_fee ?? 0);
        $totalDiscount = $enquiries->sum('discount_amount');
        $totalPaid = $enquiries->sum(fn($e) => $e->payments->sum('amount_paid'));
        $totalPending = max(0, $totalFinalFee - $totalPaid);

        return view('dashboard.reports.revenue', compact(
            'enquiries', 'startDate', 'endDate', 'month', 'year',
            'totalFinalFee', 'totalPaid', 'totalPending', 'totalDiscount'
        ));
    }

    //Expeneses related Report 
    public function expenses(Request $request)
    {
        // If no filters applied, set default to current month/year
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $query = Expense::query();

        // Apply filters
        if ($request->filled('branch_name')) {
            $query->where('branch_name', $request->branch_name);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }

        // Apply month/year filters only if set (even default ones)
        if (!empty($month)) {
            $query->whereMonth('date', $month);
        }

        if (!empty($year)) {
            $query->whereYear('date', $year);
        }

        $expenses = $query->orderBy('date', 'desc')->paginate(10);
        $totalExpense = $query->sum('amount');

        return view('dashboard.reports.expenses', compact('expenses', 'totalExpense', 'month', 'year'));
    }



}

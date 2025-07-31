<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Models\Enquiry;
use App\Models\Payment;
use App\Models\Expense;
use Carbon\Carbon;

class ReportsController extends Controller
{
    //Revenue Related Report
    public function revenue(Request $request)
    {
        $month = $request->input('month'); // Could be null (All Months)
        $year = $request->input('year');

        // Handle month/year logic properly
        if ($year && !$month) {
            // Filter by year only
            $startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $endDate = Carbon::createFromDate($year, 12, 31)->endOfYear();
        } elseif ($year && $month) {
            // Filter by both month and year
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        } else {
            // Default to current month & year
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $year = $startDate->year;
            $month = $startDate->month;
        }

        // Build base query
        $baseQuery = Enquiry::with(['payments' => function ($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate]);
        }])->whereBetween('created_at', [$startDate, $endDate]);

        // Apply additional filters
        if ($request->filled('branch_name')) {
            $baseQuery->where('branch_name', $request->branch_name);
        }

        if ($request->filled('admission_for')) {
            $baseQuery->where('admission_for', $request->admission_for);
        }

        if ($request->filled('student_name')) {
            $baseQuery->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->student_name . '%')
                    ->orWhere('surname', 'like', '%' . $request->student_name . '%');
            });
        }

        // Apply pagination (clone query first)
        $paginatedEnquiries = (clone $baseQuery)
        ->orderBy('created_at', 'desc') 
        ->paginate(5)
        ->withQueryString();
        $allEnquiries = $baseQuery->get(); // for summary

        // Summary calculations from all filtered enquiries
        $totalFinalFee = $allEnquiries->sum(fn($e) => $e->final_fee ?? $e->default_fee ?? 0);
        $totalDiscount = $allEnquiries->sum('discount_amount');
        $totalPaid = $allEnquiries->sum(fn($e) => $e->payments->sum('amount_paid'));
        $totalPending = max(0, $totalFinalFee - $totalPaid);

        return view('dashboard.reports.revenue', compact(
            'paginatedEnquiries', 'startDate', 'endDate', 'month', 'year',
            'totalFinalFee', 'totalPaid', 'totalPending', 'totalDiscount'
        ));
    }



    //Expeneses related Report 
    public function expenses(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        if ($year && !$month) {
            $startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $endDate = Carbon::createFromDate($year, 12, 31)->endOfYear();
        } elseif ($year && $month) {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $year = $startDate->year;
            $month = $startDate->month;
        }

        // Base query (with eager loading)
        $query = Expense::with('category')  // assuming relationship is defined
                        ->whereBetween('date', [$startDate, $endDate]);

        if ($request->filled('branch_name')) {
            $query->where('branch_name', $request->branch_name);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category); // Use category_id
        }

        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }

        $totalExpense = $query->sum('amount');
        $expenses = (clone $query)
                ->with('category')
                ->orderBy('created_at', 'desc') // Show latest added on top
                ->paginate(5)
                ->withQueryString();

        $categories = ExpenseCategory::orderBy('created_at', 'desc')->get();

        return view('dashboard.reports.expenses', compact(
            'expenses', 'totalExpense', 'month', 'year', 'categories'
        ));
    }


}

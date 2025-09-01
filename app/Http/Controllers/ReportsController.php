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
    //Revenue Related 
    public function revenue(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        // Handle month/year logic
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

        // -------------------------------
        // PART A: Enquiry-wise Metrics
        // -------------------------------
        $enquiryQuery = Enquiry::with('payments')->whereBetween('created_at', [$startDate, $endDate]);

        if ($request->filled('branch_name')) {
            $enquiryQuery->where('branch_name', $request->branch_name);
        }

        if ($request->filled('admission_for')) {
            $enquiryQuery->where('admission_for', $request->admission_for);
        }

        if ($request->filled('student_name')) {
            $enquiryQuery->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->student_name . '%')
                ->orWhere('surname', 'like', '%' . $request->student_name . '%');
            });
        }

        $paginatedEnquiries = (clone $enquiryQuery)
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        $enquiriesForSummary = $enquiryQuery->get(); // For expected revenue, discount, pending

        $totalFinalFee  = $enquiriesForSummary->sum(fn($e) => $e->final_fee ?? $e->default_fee ?? 0);
        $totalDiscount  = $enquiriesForSummary->sum('discount_amount');
        $paidFromEnquiries = $enquiriesForSummary->sum(fn($e) => $e->payments->sum('amount_paid'));
        $totalPending   = max(0, $totalFinalFee - $paidFromEnquiries);

        // -------------------------------
        // PART B: Payment-wise Metrics
        // -------------------------------
        $paymentQuery = Payment::whereBetween('created_at', [$startDate, $endDate]);

        if ($request->filled('branch_name') || $request->filled('admission_for') || $request->filled('student_name')) {
            $paymentQuery->whereHas('enquiry', function ($q) use ($request) {
                if ($request->filled('branch_name')) {
                    $q->where('branch_name', $request->branch_name);
                }
                if ($request->filled('admission_for')) {
                    $q->where('admission_for', $request->admission_for);
                }
                if ($request->filled('student_name')) {
                    $q->where('first_name', 'like', '%' . $request->student_name . '%')
                    ->orWhere('surname', 'like', '%' . $request->student_name . '%');
                }
            });
        }

        $totalPaid = $paymentQuery->sum('amount_paid'); //  Actual revenue this month

        return view('dashboard.reports.revenue', compact(
            'paginatedEnquiries', 'startDate', 'endDate', 'month', 'year',
            'totalFinalFee', 'totalDiscount', 'totalPending', 'totalPaid'
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

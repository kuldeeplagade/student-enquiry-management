@extends('dashboard')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4 mb-4">Add Payment</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('payments.store', $enquiry->id) }}" method="POST">
                @csrf

                @if (is_null($enquiry->total_amount))
                <div class="mb-3">
                    <label for="total_amount" class="form-label fw-bold">Set Total Fee (₹)</label>
                    <input type="number" name="total_amount" class="form-control" required>
                </div>
                @endif


                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Payment Mode</label>
                        <select name="payment_mode" class="form-select" required>
                            <option value="">Select</option>
                            <option value="Cash">Cash</option>
                            <option value="UPI">UPI</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Amount Paid (₹)</label>
                        <input type="number" step="0.01" class="form-control" name="amount_paid" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Notes / Remarks</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Save Payment</button>
                    <a href="{{ route('payments.index', $enquiry->id) }}" class="btn btn-secondary">Back to History</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('dashboard')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">💰 Payment History</h4>

    {{-- Student Info --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="fw-bold text-dark">Name:</label>
            <div class="form-control">
                {{ $enquiry->surname }} {{ $enquiry->first_name }} {{ $enquiry->middle_name }}
            </div>
        </div>
        <div class="col-md-4">
            <label class="fw-bold text-dark">Class:</label>
            <div class="form-control">
                {{ $enquiry->admission_for }}
            </div>
        </div>
    </div>

    {{-- Payment Summary --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="fw-bold text-dark">Total Fee (₹):</label>
            <div class="form-control">
                {{ $enquiry->total_amount ?? 'Not Set' }}
            </div>
        </div>
        <div class="col-md-4">
            <label class="fw-bold text-dark">Total Paid (₹):</label>
            <div class="form-control">
                {{ $enquiry->payments->sum('amount_paid') }}
            </div>
        </div>
        <div class="col-md-4">
            <label class="fw-bold text-dark">Pending Fees (₹):</label>
            <div class="form-control text-danger">
                @php
                    $total = $enquiry->total_amount ?? 0;
                    $paid = $enquiry->payments->sum('amount_paid');
                    $pending = max(0, $total - $paid);
                @endphp
                {{ $pending }}
            </div>
        </div>
    </div>

    {{-- Add Payment Button --}}
    <div class="mb-3">
        <a href="{{ route('payments.create', $enquiry->id) }}" class="btn btn-success">
         <i class="bi bi-plus-circle-fill"></i>Add Payment
        </a>
        <a href="{{ route('enquiries.index') }}" class="btn btn-secondary">
            <i class="bi bi-skip-backward"></i> Back to Enquiries
        </a>
    </div>

    {{-- Payment History Table --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">📋 Payment History</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>SN</th>
                        <th>Payment Mode</th>
                        <th>Amount Paid (₹)</th>
                        <th>Notes</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enquiry->payments as $index => $payment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $payment->payment_mode }}</td>
                            <td>{{ $payment->amount_paid }}</td>
                            <td>{{ $payment->notes ?? '-' }}</td>
                            <td>{{ $payment->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No payments recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

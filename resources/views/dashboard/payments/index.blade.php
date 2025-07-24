@extends('dashboard')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4 d-flex align-items-center">
        <i class="bi bi-wallet2 text-dark fs-4 me-2"></i> Payment History
    </h4>

    {{-- Student Info --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="fw-semibold text-dark">Name:</label>
            <div class="form-control bg-light">
                {{ $enquiry->surname }} {{ $enquiry->first_name }} {{ $enquiry->middle_name }}
            </div>
        </div>
        <div class="col-md-4">
            <label class="fw-semibold text-dark">Class:</label>
            <div class="form-control bg-light">
                {{ $enquiry->admission_for }}
            </div>
        </div>
    </div>

    {{-- Payment Summary --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="fw-semibold text-dark">Total Fee (₹):</label>
            <div class="form-control bg-light">
                {{ $enquiry->total_amount ?? 'Not Set' }}
            </div>
        </div>
        <div class="col-md-4">
            <label class="fw-semibold text-dark">Total Paid (₹):</label>
            <div class="form-control bg-light">
                {{ $enquiry->payments->sum('amount_paid') }}
            </div>
        </div>
        <div class="col-md-4">
            <label class="fw-semibold text-dark">Pending Fees (₹):</label>
            <div class="form-control bg-light text-danger fw-bold">
                @php
                    $total = $enquiry->total_amount ?? 0;
                    $paid = $enquiry->payments->sum('amount_paid');
                    $pending = max(0, $total - $paid);
                @endphp
                {{ $pending }}
            </div>
        </div>
    </div>

    {{-- Add Payment & Back Button --}}
    <div class="mb-4 d-flex gap-2">
        <a href="{{ route('payments.create', $enquiry->id) }}" class="btn btn-success">
            <i class="bi bi-plus-circle-fill me-1"></i> Add Payment
        </a>
        <a href="{{ route('enquiries.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle me-1"></i> Back to Enquiries
        </a>
    </div>

    {{-- Payment History Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 d-flex align-items-center">
                <i class="bi bi-receipt me-2"></i> Payment History
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
<table class="table table-bordered table-hover align-middle text-center mb-0">
    <thead class="custom-thead">
                        <tr>
                            <th>SN</th>
                            <th>Payment Mode</th>
                            <th>Amount Paid (₹)</th>
                            <th>Notes</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enquiry->payments->sortByDesc('created_at')->values() as $index => $payment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $payment->payment_mode }}</td>
                                <td>₹{{ $payment->amount_paid }}</td>
                                <td>{{ $payment->notes ?? '-' }}</td>
                                <td>{{ $payment->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-emoji-frown me-2 fs-5"></i> No payments recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .custom-thead {
        background-color: #e3f2fd !important;
        color: #212529 !important;
    }
</style>


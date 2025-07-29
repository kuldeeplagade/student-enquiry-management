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
    @php
        $defaultFee = $enquiry->default_fee ?? 0;
        $finalFee = $enquiry->final_fee ?? $defaultFee;
        $paid = $enquiry->payments->sum('amount_paid');
        $pending = max(0, $finalFee - $paid);
        $discount = $enquiry->discount_amount ?? 0;
    @endphp

    <div class="row mb-4">
        <div class="col-md-3">
            <label class="fw-semibold text-dark">Base Fee (₹):</label>
            <div class="form-control bg-light">
                {{ number_format($defaultFee, 2) }}
            </div>
        </div>
        <div class="col-md-3">
            <label class="fw-semibold text-dark">Discount (₹):</label>
            <div class="form-control bg-light">
                {{ number_format($discount, 2) }}
            </div>
        </div>
        <div class="col-md-3">
            <label class="fw-semibold text-dark">Final Payable Fee (₹):</label>
            <div class="form-control bg-light">
                {{ number_format($finalFee, 2) }}
            </div>
        </div>
        <div class="col-md-3">
            <label class="fw-semibold text-dark">Pending Amount (₹):</label>
            <div class="form-control bg-light text-danger fw-bold">
                {{ number_format($pending, 2) }}
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-4 d-flex gap-2">
        <a href="{{ route('payments.create', $enquiry->id) }}" class="btn btn-success">
            <i class="bi bi-plus-circle-fill me-1"></i> Add Payment
        </a>
        <a href="{{ route('enquiries.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle me-1"></i> Back to Enquiries
        </a>
        @if (is_null($enquiry->final_fee))
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#discountModal">
            <i class="bi bi-tag-fill me-1"></i> Add Discount Amount
        </button>
        @endif
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

{{-- Add Discount Modal --}}
<div class="modal fade" id="discountModal" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('discount.update', $enquiry->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="discountModalLabel">Add Discount Amount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Base Fee (₹)</label>
                        <input type="text" class="form-control" value="{{ number_format($defaultFee, 2) }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="discount_amount" class="form-label">Discount Amount (₹)</label>
                        <input type="number" name="discount_amount" id="discount_amount" class="form-control" min="0" step="0.01" oninput="calculateDiscountedFee()">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Final Payable Fee (₹)</label>
                        <input type="text" id="final_fee_display" class="form-control bg-light" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Discount</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function calculateDiscountedFee() {
        const base = parseFloat({{ $defaultFee }}) || 0;
        const discount = parseFloat(document.getElementById('discount_amount').value) || 0;
        const final = base - discount;
        document.getElementById('final_fee_display').value = final > 0 ? final.toFixed(2) : 0;
    }
</script>
@endsection

<style>
    .custom-thead {
        background-color: #e3f2fd !important;
        color: #212529 !important;
    }
</style>

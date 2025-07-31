@extends('dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-cash"></i> Add New Expense</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('expenses.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount (₹) <span class="text-danger">*</span></label>
            <input type="number" name="amount" step="0.01" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date <span class="text-danger">*</span></label>
            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Mode <span class="text-danger">*</span></label>
            <select name="payment_mode" class="form-select" required>
                <option value="">--Select Payment Mode--</option>
                <option value="Cash">Cash</option>
                <option value="UPI">UPI</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Cheque">Cheque</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Category <span class="text-danger">*</span></label>
            <select name="category" class="form-select" required>
                <option value="">--Select Category--</option>
                @foreach($categories as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Branch Name <span class="text-danger">*</span></label>
            <select name="branch_name" class="form-control" required>
                <option value="">-- Select Branch --</option>
                <option value="Mumbai Branch 1" {{ old('branch_name') == 'Mumbai Branch 1' ? 'selected' : '' }}>
                    Mumbai Branch 1
                </option>
                <option value="Mumbai Branch 2" {{ old('branch_name') == 'Mumbai Branch 2' ? 'selected' : '' }}>
                    Mumbai Branch 2
                </option>
            </select>
        </div>


        <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> Save Expense
        </button>
    </form>
</div>
@endsection

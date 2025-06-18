@extends('dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Add New Expense</h2>

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
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">💾 Save Expense</button>
    </form>
</div>
@endsection

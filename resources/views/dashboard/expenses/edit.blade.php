@extends('dashboard')

@section('content')
<div class="container mt-4">
    <h3><i class="bi bi-pencil-square me-2"></i>Edit Expense</h3>
    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $expense->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount (₹)</label>
            <input type="number" name="amount" class="form-control" value="{{ $expense->amount }}" step="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="{{ $expense->date }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Mode</label>
            <select name="payment_mode" class="form-select" required>
                <option value="">-- Select Payment Mode --</option>
                @foreach(['Cash', 'UPI', 'Bank Transfer', 'Cheque', 'Other'] as $mode)
                    <option value="{{ $mode }}" {{ $expense->payment_mode === $mode ? 'selected' : '' }}>{{ $mode }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Expense Category</label>
            <select name="category" class="form-select">
                <!-- <option value="">-- Select Category --</option> -->
                @foreach ($categories as $cat)
                    <option value="{{ $cat->name }}"
                        {{ old('category', $expense->category) === $cat->name ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Branch Name</label>
            <select name="branch_name" class="form-select">
                <option value="">-- Select Branch --</option>
                <option value="Mumbai Branch 1" {{ old('branch_name', $expense->branch_name) == 'Mumbai Branch 1' ? 'selected' : '' }}>Mumbai Branch 1</option>
                <option value="Mumbai Branch 2" {{ old('branch_name', $expense->branch_name) == 'Mumbai Branch 2' ? 'selected' : '' }}>Mumbai Branch 2</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Notes (optional)</label>
            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $expense->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> Update
        </button>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle me-1"></i> Cancel
        </a>
    </form>
</div>
@endsection

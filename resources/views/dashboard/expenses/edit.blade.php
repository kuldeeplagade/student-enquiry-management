@extends('dashboard')

@section('content')
<div class="container mt-4">
    <h3>Edit Expense</h3>
    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $expense->title }}" required>
        </div>

        <div class="mb-3">
            <label>Amount (₹)</label>
            <input type="number" name="amount" class="form-control" value="{{ $expense->amount }}" required>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="{{ $expense->date }}" required>
        </div>

        <div class="mb-3">
            <label>Notes (optional)</label>
            <textarea name="notes" class="form-control">{{ $expense->notes }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">💾 Update</button>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">↩️ Cancel</a>
    </form>
</div>
@endsection

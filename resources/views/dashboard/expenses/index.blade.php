@extends('dashboard')

@section('content')
<div class="container">
    <h2 class="mb-3">Expense Summary</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('expenses.create') }}" class="btn btn-primary">➕ Add Expense</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5><strong>Total Expenses (₹):</strong> {{ number_format($total, 2) }}</h5>
        </div>
    </div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Amount (₹)</th>
            <th>Date</th>
            <th>Notes</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($expenses as $expense)
            <tr>
                <td>{{ $expense->id }}</td>
                <td>{{ $expense->title }}</td>
                <td>₹{{ number_format($expense->amount, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                <td>{{ $expense->notes }}</td>
                <td>
                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-primary">✏️ Edit</a>

                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this expense?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">🗑️ Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No expenses found.</td></tr>
        @endforelse
    </tbody>
</table>

</div>
@endsection

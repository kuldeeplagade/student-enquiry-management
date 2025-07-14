@extends('dashboard')

@section('content')
<div class="container">
    <h2 class="mb-3 d-flex align-items-center">
        <i class="bi bi-cash-coin text-dark fs-4 me-2"></i> Expense Summary
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('expenses.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Add Expense
        </a>  
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="mb-0 text-dark"><strong>Total Expenses (₹):</strong> {{ number_format($total, 2) }}</h5>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 align-middle text-center">
                    <thead class="table-primary text-dark">
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
                                <td>{{ ($expenses->currentPage() - 1) * $expenses->perPage() + $loop->iteration }}</td>
                                <td>{{ $expense->title }}</td>
                                <td>₹{{ number_format($expense->amount, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                                <td>{{ $expense->notes }}</td>
                                <td>
                                    <a href="{{ route('expenses.edit', $expense->id) }}" 
                                       class="btn btn-sm custom-btn edit-btn me-1 mb-1">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>

                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm custom-btn delete-btn mb-1">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-emoji-frown fs-4 me-2"></i> No expenses found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        @include('components.shared-pagination', ['paginator' => $expenses])
    </div>
</div>

<!-- Design Styling -->
<style>
    .custom-btn {
        color: #fff;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.875rem;
        transition: background-color 0.3s ease;
    }

    .edit-btn {
        background-color: #f0ad4e;
    }

    .edit-btn:hover {
        background-color: #e0962f;
    }

    .delete-btn {
        background-color: #d9534f;
    }

    .delete-btn:hover {
        background-color: #c9302c;
    }
</style>
@endsection

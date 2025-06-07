<!DOCTYPE html>
<html>
<head>
    <title>Expenses List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Expenses List (Visible only to Super Admin)</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Add New Expense</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Category</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $expense)
                <tr>
                    <td>{{ $expense->id }}</td>
                    <td>{{ $expense->title }}</td>
                    <td>{{ $expense->amount }}</td>
                    <td>{{ $expense->category ?? '-' }}</td>
                    <td>{{ $expense->note ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No expenses found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Add Expense</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Expense</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control" required value="{{ old('amount') }}">
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" id="category" class="form-control" value="{{ old('category') }}">
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Save Expense</button>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>

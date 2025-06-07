<!DOCTYPE html>
<html>
<head>
    <title>All Enquiries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Enquiry List by Class</h2>

    {{-- Filter Dropdown --}}
    <form method="GET" action="{{ route('enquiries.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="class" id="class" class="form-select" onchange="this.form.submit()">
                    <option value="All" {{ $selectedClass == 'All' ? 'selected' : '' }}>All</option>
                    @if(is_array($classes))
                        @foreach($classes as $class)
                            <option value="{{ $class }}" {{ $selectedClass == $class ? 'selected' : '' }}>
                                {{ $class }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </form>

    {{-- Super Admin Link to just show when the login super admin  --}}
    @auth
        @if(auth()->user()->is_super_admin)
            <div class="mb-3">
                <a href="{{ route('expenses.index') }}" class="btn btn-success">
                    View Expenses (Super Admin Only)
                </a>
            </div>
        @endif
    @endauth

    {{-- Single Table for All Enquiries --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Candidate Name</th>
                        <th>DOB</th>
                        <th>Parent Contact</th>
                        <th>Class</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enquiries as $enquiry)
                        <tr>
                            <td>{{ $enquiry->id }}</td>
                            <td>{{ $enquiry->candidate_name }}</td>
                            <td>{{ $enquiry->dob }}</td>
                            <td>{{ $enquiry->parent_contact }}</td>
                            <td>{{ $enquiry->admission_for }}</td>
                            <td>
                                <a href="{{ route('enquiries.edit', $enquiry->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No enquiries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>

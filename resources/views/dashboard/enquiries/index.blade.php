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

    {{-- Super Admin View Expenses Button --}}
    @auth
        @if(auth()->user()->role === 'superadmin')
            <div class="mb-3">
                <a href="{{ route('expenses.index') }}" class="btn btn-success">
                    View Expenses (Super Admin Only)
                </a>
            </div>
        @endif
    @endauth

    {{-- Enquiry Table --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>DOB</th>
                        <th>Sex</th>
                        <th>Father Mobile</th>
                        <th>Mother Mobile</th>
                        <th>Email</th>
                        <th>Class</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enquiries as $enquiry)
                        <tr>
                            <td>{{ $enquiry->id }}</td>
                            <td>{{ $enquiry->surname }} {{ $enquiry->first_name }} {{ $enquiry->middle_name }}</td>
                            <td>{{ $enquiry->dob }}</td>
                            <td>{{ $enquiry->sex }}</td>
                            <td>{{ $enquiry->father_mobile }}</td>
                            <td>{{ $enquiry->mother_mobile }}</td>
                            <td>{{ $enquiry->email }}</td>
                            <td>{{ $enquiry->admission_for }}</td>
                            <td>
                                <a href="{{ route('enquiries.edit', $enquiry->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No enquiries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>

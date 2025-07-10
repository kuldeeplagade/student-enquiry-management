@extends('dashboard')

@section('content')
<h2 class="mb-4">
    <i class="bi bi-journal-text text-dark fs-7 me-2"></i>Enquiry List
</h2>

<form method="GET" action="{{ route('enquiries.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <select name="class" id="class" class="form-select" onchange="this.form.submit()">
                <option value="All" {{ $selectedClass == 'All' ? 'selected' : '' }}>All</option>
                @if(is_array($classes))
                    @foreach($classes as $class)
                        <option value="{{ $class }}" {{ $selectedClass == $class ? 'selected' : '' }}>{{ $class }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</form>

<div class="card">
    <div class="card-body p-0 enquiry-table-wrapper">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Candidate Name</th>
                    <th>DOB</th>
                    <th>Contact</th>
                    <th>Class</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $index = ($enquiries->currentPage() - 1) * $enquiries->perPage() + 1; @endphp
                @forelse($enquiries as $enquiry)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $enquiry->first_name }} {{ $enquiry->surname }}</td>
                    <td>{{ $enquiry->dob }}</td>
                    <td>{{ $enquiry->father_mobile }}</td>
                    <td>{{ $enquiry->admission_for }}</td>
                    <td>
                        <a href="{{ route('enquiries.edit', $enquiry->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('enquiries.show', $enquiry->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('payments.index', $enquiry->id) }}" class="btn btn-sm btn-warning">💰 Payment</a>
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

<!-- Pagination aligned bottom-right -->
<div class="mt-3 d-flex justify-content-end">
    {{ $enquiries->appends(['class' => $selectedClass])->links() }}
</div>
@endsection

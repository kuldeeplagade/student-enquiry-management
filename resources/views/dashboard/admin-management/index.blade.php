@extends('dashboard')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4 d-flex align-items-center">
        <i class="bi bi-person-gear text-dark me-2 fs-4"></i> Admin Management
    </h4>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="custom-thead">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Change Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>
                                    <a href="{{ route('admin.password.edit', $user->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-key me-1"></i> Change Password
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    .custom-thead {
        background-color: #e3f2fd !important; /* Light blue */
        color: #212529 !important;           /* Dark text */
    }

    /* Optional: make header text bold and paddings nicer */
    .custom-thead th {
        font-weight: 600;
        padding: 12px 10px;
    }

    /* Optional: slightly softer borders */
    table.table th,
    table.table td {
        border-color: #dee2e6;
    }
</style>


@extends('dashboard')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">
    <i class="bi bi-person-gear text-dark me-2"></i> Admin Management
    </h4>

    <table class="table table-bordered bg-white">
        <thead class="table-light">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-center">Change Password</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.password.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">Change Password</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

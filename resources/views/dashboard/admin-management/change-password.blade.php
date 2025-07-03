@extends('dashboard')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">🔑 Change Password for {{ $user->name }}</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.password.update', $user->id) }}">
        @csrf

        {{-- New Password --}}
        <div class="mb-3 position-relative">
            <label for="password" class="form-label">New Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required minlength="6">
                <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword('password', this)">
                </span>
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-3 position-relative">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword('password_confirmation', this)">
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>

{{-- Password toggle JS --}}
<script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection

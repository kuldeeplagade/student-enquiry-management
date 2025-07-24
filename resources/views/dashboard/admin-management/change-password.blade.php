@extends('dashboard')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4 d-flex align-items-center">
        <i class="bi bi-shield-lock-fill text-primary me-2 fs-4"></i>
        Change Password for <span class="ms-1">{{ $user->name }}</span>
    </h4>

    {{-- ✅ Success Message --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ Password Change Form --}}
    <form method="POST" action="{{ route('admin.password.update', $user->id) }}">
        @csrf

        {{-- New Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required minlength="6">
                <span class="input-group-text" onclick="togglePassword(this, 'password')" style="cursor: pointer;">
                    <i class="bi bi-eye"></i>
                </span>
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control" required>
                <span class="input-group-text" onclick="togglePassword(this, 'password_confirmation')" style="cursor: pointer;">
                    <i class="bi bi-eye"></i>
                </span>
            </div>
        </div>

        {{-- ✅ Submit and Back Buttons --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-outline-primary">
                <i class="bi bi-save me-1"></i> Update Password
            </button>

            <a href="{{ route('admin.management') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to Admin Management
            </a>
        </div>
    </form>
</div>

{{-- ✅ Toggle Password JS --}}
<script>
    function togglePassword(span, fieldId) {
        const input = document.getElementById(fieldId);
        const icon = span.querySelector('i');

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
@endsection

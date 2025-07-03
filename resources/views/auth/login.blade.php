<!DOCTYPE html>
<html>
<head>
    <title>Login | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-card {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 30px;
            background-color: #fff;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="login-card" style="width: 100%; max-width: 450px;">
        <h3 class="text-center text-primary mb-4">Admin Login</h3>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">📧 Email address <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                    autocomplete="email" required autofocus>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">🔒 Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" id="password" name="password"
                        class="form-control" autocomplete="current-password" required>
                    <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                        <img id="toggleIcon" src="https://cdn-icons-png.flaticon.com/512/159/159604.png" width="20" alt="Toggle" />
                    </span>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <!-- ✅ Remember Me -->
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Remember Me
                </label>
            </div>

            <button type="submit" class="btn btn-primary w-100">🔐 Login</button>
        </form>
    </div>
</div>

<!-- Password toggle script -->
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.src = 'https://cdn-icons-png.flaticon.com/512/709/709612.png'; // open eye
        } else {
            passwordInput.type = 'password';
            icon.src = 'https://cdn-icons-png.flaticon.com/512/159/159604.png'; // closed eye
        }
    }
</script>

</body>
</html>

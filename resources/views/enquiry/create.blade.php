<!DOCTYPE html>
<html>
<head>
    <title>Student Enquiry Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
        }
        .form-box {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="form-box">

        <h2 class="mb-4 text-center">Student Enquiry Form</h2>

        {{-- Success Toast --}}
        @if(session('success'))
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
                <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('enquiry.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="candidate_name" class="form-label">Candidate Name</label>
                <input type="text" class="form-control" name="candidate_name" value="{{ old('candidate_name') }}" required>
            </div>

            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="dob" value="{{ old('dob') }}" required>
            </div>

            <div class="mb-3">
                <label for="parent_contact" class="form-label">Parent Contact</label>
                <input type="text" class="form-control" name="parent_contact" value="{{ old('parent_contact') }}" required>
            </div>

            <div class="mb-4">
                <label for="admission_for" class="form-label">Admission For</label>
                <select class="form-select" name="admission_for" required>
                    <option value="">-- Select Class --</option>
                    <option value="Playgroup" {{ old('admission_for') == 'Playgroup' ? 'selected' : '' }}>Playgroup</option>
                    <option value="Nursery" {{ old('admission_for') == 'Nursery' ? 'selected' : '' }}>Nursery</option>
                    <option value="Jr.KG" {{ old('admission_for') == 'Jr.KG' ? 'selected' : '' }}>Jr.KG</option>
                    <option value="Sr.KG" {{ old('admission_for') == 'Sr.KG' ? 'selected' : '' }}>Sr.KG</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit Enquiry</button>
        </form>

        <div class="text-center mt-4">
            <p>Are you an Admin or Superadmin? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>
</div>

{{-- JS + Toast Auto Hide --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toastEl = document.querySelector('.toast');
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();
    }
</script>

</body>
</html>

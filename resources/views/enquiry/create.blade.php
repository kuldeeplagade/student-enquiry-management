<!DOCTYPE html>
<html>
<head>
    <title>Enquiry Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Student Enquiry Form</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

        <div class="mb-3">
            <label for="admission_for" class="form-label">Admission For</label>
            <select class="form-control" name="admission_for" required>
                <option value="">-- Select Class --</option>
                <option value="Playgroup">Playgroup</option>
                <option value="Nursery">Nursery</option>
                <option value="Jr.KG">Jr.KG</option>
                <option value="Sr.KG">Sr.KG</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit Enquiry</button>
    </form>

    <div class="mt-4">
        <p>Are you an Admin or Superadmin? <a href="{{ route('login') }}">Login here</a></p>
    </div>
</div>
</body>
</html>

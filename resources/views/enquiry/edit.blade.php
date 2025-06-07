<!DOCTYPE html>
<html>
<head>
    <title>Edit Enquiry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 600px;">
    <h2>Edit Enquiry</h2>

    <form action="{{ route('enquiries.update', $enquiry->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Candidate Name</label>
            <input type="text" class="form-control" name="candidate_name" value="{{ old('candidate_name', $enquiry->candidate_name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">DOB</label>
            <input type="date" class="form-control" name="dob" value="{{ old('dob', $enquiry->dob) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Parent Contact</label>
            <input type="text" class="form-control" name="parent_contact" value="{{ old('parent_contact', $enquiry->parent_contact) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Admission For</label>
            <select class="form-select" name="admission_for" required>
                @foreach(['Playgroup', 'Nursery', 'Jr.KG', 'Sr.KG'] as $class)
                    <option value="{{ $class }}" {{ $enquiry->admission_for == $class ? 'selected' : '' }}>{{ $class }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Enquiry</button>
        <a href="{{ route('enquiries.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>

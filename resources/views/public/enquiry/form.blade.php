@extends('layouts.app')

@section('content')
<div class="card shadow p-4">
    <h3 class="mb-4 text-primary">Student Enquiry Form</h3>

    @if(session('success'))
        <!-- Trigger the modal using JavaScript -->
        <script>
            window.addEventListener('DOMContentLoaded', function () {
                let myModal = new bootstrap.Modal(document.getElementById('successModal'));
                myModal.show();
            });
        </script>
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
            <select class="form-select" name="admission_for" required>
                <option value="">-- Select Class --</option>
                <option value="Playgroup">Playgroup</option>
                <option value="Nursery">Nursery</option>
                <option value="Jr.KG">Jr.KG</option>
                <option value="Sr.KG">Sr.KG</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Submit Enquiry</button>
    </form>

    <div class="mt-4">
        <p class="text-muted">Are you an Admin or Superadmin? <a href="{{ route('login') }}">Login here</a></p>
    </div>
</div>

<!-- Success Modal -->
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="successModalLabel">Success</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ session('success') }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endif

@endsection

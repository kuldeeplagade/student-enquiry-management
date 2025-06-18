@extends('layouts.app')

@section('content')
<div class="card shadow p-4">
    <h3 class="mb-4 text-primary">Student Enquiry Form</h3>

    @if(session('success'))
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

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Surname <span class="text-danger">*</span></label>
                <input type="text" name="surname" class="form-control" value="{{ old('surname') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Middle Name</label>
                <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name') }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" name="dob" class="form-control" value="{{ old('dob') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Sex <span class="text-danger">*</span></label>
                <select name="sex" class="form-select" required>
                    <option value="">-- Select --</option>
                    <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('sex') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Blood Group</label>
                <input type="text" name="blood_group" class="form-control" value="{{ old('blood_group') }}">
            </div>
        </div>

<div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label">Father's Mobile No. <span class="text-danger">*</span></label>
        <input type="text" name="father_mobile" class="form-control"
               placeholder="Enter 10-digit mobile (without +91)"
               value="{{ old('father_mobile') }}" required
               pattern="\d{10}" maxlength="10" minlength="10"
               title="Enter 10-digit mobile number without +91">

        </div>
            <div class="col-md-4">
                <label class="form-label">Mother's Mobile No.<span class="text-danger">*</span></label>
                <input type="text" name="mother_mobile" class="form-control"
                    placeholder="Enter 10-digit mobile (without +91)"
                    value="{{ old('mother_mobile') }}" required
                    pattern="\d{10}" maxlength="10" minlength="10"
                    title="Enter 10-digit mobile number without +91">
            </div>
            <div class="col-md-4">
                <label class="form-label">Landline No.</label>
                <input type="text" name="landline" class="form-control" value="{{ old('landline') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter valid email" value="{{ old('email') }}">
        </div>

        <!-- Address -->
        <h5 class="text-primary mt-4">Address Details</h5>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">State</label>
                <input type="text" name="state" class="form-control" value="{{ old('state') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" value="{{ old('city') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">PIN Code</label>
                <input type="text" name="pin" class="form-control" value="{{ old('pin') }}">
            </div>
        </div>

        <!-- Siblings -->
        <h5 class="text-primary mt-4">Siblings / Reference Details</h5>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Sibling Name (1)</label>
                <input type="text" name="sibling1_name" class="form-control" value="{{ old('sibling1_name') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sex</label>
                <select name="sibling1_sex" class="form-select">
                    <option value="">--</option>
                    <option value="Male" {{ old('sibling1_sex') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('sibling1_sex') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('sibling1_sex') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="sibling1_dob" class="form-control" value="{{ old('sibling1_dob') }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Sibling Name (2)</label>
                <input type="text" name="sibling2_name" class="form-control" value="{{ old('sibling2_name') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sex</label>
                <select name="sibling2_sex" class="form-select">
                    <option value="">--</option>
                    <option value="Male" {{ old('sibling2_sex') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('sibling2_sex') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('sibling2_sex') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="sibling2_dob" class="form-control" value="{{ old('sibling2_dob') }}">
            </div>
        </div>

        <!--Submit button--->
        <div class="text-end">
            <button type="submit" class="btn btn-success">Submit Enquiry</button>
        </div>
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

@extends('layouts.public-form')

@section('content')
<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white px-4 py-3 shadow-sm mb-3 rounded-bottom">
    <div class="container-fluid">
        <h4 class="mb-0 fw-bold" style="font-family: 'Comic Sans MS', cursive; color: #6B297D;">
            <i class="bi bi-person-vcard me-2"></i> Student Enquiry Form
        </h4>

    </div>
</nav>

<!-- Main Card -->
<div class="card shadow border-0 p-4 mb-5" style="background-color: #fff6fb; border-radius: 20px; font-family: 'Comic Sans MS', cursive;">
    @if(session('success'))
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            let myModal = new bootstrap.Modal(document.getElementById('successModal'));
            myModal.show();
        });
    </script>
    @endif

    @if($errors->any())
    <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('enquiry.store') }}" method="POST">
        @csrf

        {{-- Basic Info --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label">Surname <span class="text-">*</span></label>
                <input type="text" name="surname" class="form-control rounded-pill shadow-sm" required value="{{ old('surname') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" name="first_name" class="form-control rounded-pill shadow-sm" required value="{{ old('first_name') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Middle Name</label>
                <input type="text" name="middle_name" class="form-control rounded-pill shadow-sm" value="{{ old('middle_name') }}">
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" name="dob" class="form-control rounded-pill shadow-sm" required value="{{ old('dob') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Sex <span class="text-danger">*</span></label>
                <select name="sex" class="form-select rounded-pill shadow-sm" required>
                    <option value="">-- Select --</option>
                    <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('sex') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Blood Group</label>
                <input type="text" name="blood_group" class="form-control rounded-pill shadow-sm" value="{{ old('blood_group') }}">
            </div>
        </div>

        {{-- Parent Contact Info --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label">Father's Mobile <span class="text-danger">*</span></label>
                <input type="text" name="father_mobile" class="form-control rounded-pill shadow-sm" required pattern="\d{10}" maxlength="10" value="{{ old('father_mobile') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Mother's Mobile <span class="text-danger">*</span></label>
                <input type="text" name="mother_mobile" class="form-control rounded-pill shadow-sm" required pattern="\d{10}" maxlength="10" value="{{ old('mother_mobile') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Landline</label>
                <input type="text" name="landline" class="form-control rounded-pill shadow-sm" value="{{ old('landline') }}">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control rounded-pill shadow-sm" placeholder="example@email.com" value="{{ old('email') }}">
        </div>

        {{-- Address --}}
        <h5 class="fw-bold mb-3" style="color: #6B297D;"><i class="bi bi-house-door me-2"></i> Address Details</h5>
        <div class="mb-3">
            <label class="form-label">Full Address</label>
            <textarea name="address" class="form-control shadow-sm rounded-4" rows="2">{{ old('address') }}</textarea>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label">State</label>
                <input type="text" name="state" class="form-control rounded-pill shadow-sm" value="{{ old('state') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control rounded-pill shadow-sm" value="{{ old('city') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">PIN Code</label>
                <input type="text" name="pin" class="form-control rounded-pill shadow-sm" value="{{ old('pin') }}">
            </div>
        </div>

        {{-- Siblings --}}
        <h5 class="fw-bold mb-3" style="color: #6B297D;"><i class="bi bi-people-fill me-2"></i> Sibling / Reference Info</h5>
        <div class="row mb-3">
            <div class="col-md-4 mb-3">
                <label class="form-label">Sibling 1 Name</label>
                <input type="text" name="sibling1_name" class="form-control rounded-pill shadow-sm" value="{{ old('sibling1_name') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Sex</label>
                <select name="sibling1_sex" class="form-select rounded-pill shadow-sm">
                    <option value="">--</option>
                    <option value="Male" {{ old('sibling1_sex') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('sibling1_sex') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('sibling1_sex') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="sibling1_dob" class="form-control rounded-pill shadow-sm" value="{{ old('sibling1_dob') }}">
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label">Sibling 2 Name</label>
                <input type="text" name="sibling2_name" class="form-control rounded-pill shadow-sm" value="{{ old('sibling2_name') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Sex</label>
                <select name="sibling2_sex" class="form-select rounded-pill shadow-sm">
                    <option value="">--</option>
                    <option value="Male" {{ old('sibling2_sex') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('sibling2_sex') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('sibling2_sex') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="sibling2_dob" class="form-control rounded-pill shadow-sm" value="{{ old('sibling2_dob') }}">
            </div>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn px-5 py-2 rounded-pill shadow" style="background-color: #6B297D; color: white;">
                Submit Enquiry
            </button>
        </div>
    </form>
</div>

<!-- Success Modal -->
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-light rounded-4 shadow">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="successModalLabel">✅ Success</h5>
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

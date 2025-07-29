@extends('dashboard')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4 mb-4">View Enquiry</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">

                {{-- Student Info --}}
                <div class="col-md-4">
                    <label class="form-label">Surname</label>
                    <input type="text" class="form-control" value="{{ $enquiry->surname }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" value="{{ $enquiry->first_name }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Middle Name</label>
                    <input type="text" class="form-control" value="{{ $enquiry->middle_name }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label">DOB</label>
                    <input type="text" class="form-control" value="{{ $enquiry->dob }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sex</label>
                    <input type="text" class="form-control" value="{{ $enquiry->sex }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Blood Group</label>
                    <input type="text" class="form-control" value="{{ $enquiry->blood_group }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Father's Mobile</label>
                    <input type="text" class="form-control" value="{{ $enquiry->father_mobile }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mother's Mobile</label>
                    <input type="text" class="form-control" value="{{ $enquiry->mother_mobile }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Landline</label>
                    <input type="text" class="form-control" value="{{ $enquiry->landline }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" value="{{ $enquiry->email }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Admission For</label>
                    <input type="text" class="form-control" value="{{ $enquiry->admission_for }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Branch</label>
                    <input type="text" class="form-control" value="{{ $enquiry->branch_name }}" readonly>
                </div>

                {{-- Sibling 1 --}}
                <div class="col-12">
                    <hr>
                    <h5>Sibling 1</h5>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sibling 1 Name</label>
                    <input type="text" class="form-control" value="{{ $enquiry->sibling1_name }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sibling 1 Sex</label>
                    <input type="text" class="form-control" value="{{ $enquiry->sibling1_sex }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sibling 1 DOB</label>
                    <input type="text" class="form-control" value="{{ $enquiry->sibling1_dob }}" readonly>
                </div>

                {{-- Sibling 2 --}}
                <div class="col-12">
                    <hr>
                    <h5>Sibling 2</h5>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sibling 2 Name</label>
                    <input type="text" class="form-control" value="{{ $enquiry->sibling2_name }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sibling 2 Sex</label>
                    <input type="text" class="form-control" value="{{ $enquiry->sibling2_sex }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sibling 2 DOB</label>
                    <input type="text" class="form-control" value="{{ $enquiry->sibling2_dob }}" readonly>
                </div>

                {{-- Address --}}
                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <textarea class="form-control" rows="2" readonly>{{ $enquiry->address }}</textarea>
                </div>
                <div class="col-md-2">
                    <label class="form-label">State</label>
                    <input type="text" class="form-control" value="{{ $enquiry->state }}" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label">City</label>
                    <input type="text" class="form-control" value="{{ $enquiry->city }}" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Pin</label>
                    <input type="text" class="form-control" value="{{ $enquiry->pin }}" readonly>
                </div>

                <div class="col-12 mt-4 text-end">
                    <a href="{{ route('enquiries.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('dashboard')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4 mb-4">View Enquiry</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Surname</label>
                    <div class="form-control" readonly>{{ $enquiry->surname }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">First Name</label>
                    <div class="form-control" readonly>{{ $enquiry->first_name }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Middle Name</label>
                    <div class="form-control" readonly>{{ $enquiry->middle_name }}</div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">DOB</label>
                    <div class="form-control" readonly>{{ $enquiry->dob }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sex</label>
                    <div class="form-control" readonly>{{ $enquiry->sex }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Blood Group</label>
                    <div class="form-control" readonly>{{ $enquiry->blood_group }}</div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Father's Mobile</label>
                    <div class="form-control" readonly>{{ $enquiry->father_mobile }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mother's Mobile</label>
                    <div class="form-control" readonly>{{ $enquiry->mother_mobile }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Landline</label>
                    <div class="form-control" readonly>{{ $enquiry->landline }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <div class="form-control" readonly>{{ $enquiry->email }}</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Admission For</label>
                    <div class="form-control" readonly>{{ $enquiry->admission_for }}</div>
                </div>

                <div class="col-12">
                    <hr>
                    <h5>Sibling 1</h5>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sibling 1 Name</label>
                    <div class="form-control" readonly>{{ $enquiry->sibling1_name }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sibling 1 Sex</label>
                    <div class="form-control" readonly>{{ $enquiry->sibling1_sex }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sibling 1 DOB</label>
                    <div class="form-control" readonly>{{ $enquiry->sibling1_dob }}</div>
                </div>

                <div class="col-12">
                    <hr>
                    <h5>Sibling 2</h5>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sibling 2 Name</label>
                    <div class="form-control" readonly>{{ $enquiry->sibling2_name }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sibling 2 Sex</label>
                    <div class="form-control" readonly>{{ $enquiry->sibling2_sex }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sibling 2 DOB</label>
                    <div class="form-control" readonly>{{ $enquiry->sibling2_dob }}</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <div class="form-control" readonly style="height:auto;">{{ $enquiry->address }}</div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">State</label>
                    <div class="form-control" readonly>{{ $enquiry->state }}</div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">City</label>
                    <div class="form-control" readonly>{{ $enquiry->city }}</div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Pin</label>
                    <div class="form-control" readonly>{{ $enquiry->pin }}</div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('enquiries.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection

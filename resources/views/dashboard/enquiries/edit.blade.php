@extends('dashboard')

@section('content')
<div class="container-fluid px-4">
    <h3 class="mt-4 mb-4">Edit Enquiry</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('enquiries.update', $enquiry->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Surname</label>
                        <input type="text" class="form-control" name="surname" value="{{ old('surname', $enquiry->surname) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $enquiry->first_name) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name', $enquiry->middle_name) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">DOB</label>
                        <input type="date" class="form-control" name="dob" value="{{ old('dob', $enquiry->dob) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sex</label>
                        <select name="sex" class="form-select" required>
                            <option value="">Select</option>
                            @foreach(['Male', 'Female', 'Other'] as $sex)
                                <option value="{{ $sex }}" {{ $enquiry->sex == $sex ? 'selected' : '' }}>{{ $sex }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Blood Group</label>
                        <input type="text" class="form-control" name="blood_group" value="{{ old('blood_group', $enquiry->blood_group) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Father's Mobile</label>
                        <input type="text" class="form-control" name="father_mobile" value="{{ old('father_mobile', $enquiry->father_mobile) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Mother's Mobile</label>
                        <input type="text" class="form-control" name="mother_mobile" value="{{ old('mother_mobile', $enquiry->mother_mobile) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Landline</label>
                        <input type="text" class="form-control" name="landline" value="{{ old('landline', $enquiry->landline) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $enquiry->email) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Admission For</label>
                        <select name="admission_for" class="form-select" required>
                            @foreach(['Playgroup', 'Nursery', 'Jr.KG', 'Sr.KG'] as $class)
                                <option value="{{ $class }}" {{ $enquiry->admission_for == $class ? 'selected' : '' }}>{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <hr>
                        <h5>Sibling 1</h5>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sibling 1 Name</label>
                        <input type="text" class="form-control" name="sibling1_name" value="{{ old('sibling1_name', $enquiry->sibling1_name) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sibling 1 Sex</label>
                        <select name="sibling1_sex" class="form-select">
                            <option value="">Select</option>
                            @foreach(['Male', 'Female', 'Other'] as $sex)
                                <option value="{{ $sex }}" {{ $enquiry->sibling1_sex == $sex ? 'selected' : '' }}>{{ $sex }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sibling 1 DOB</label>
                        <input type="date" class="form-control" name="sibling1_dob" value="{{ old('sibling1_dob', $enquiry->sibling1_dob) }}">
                    </div>

                    <div class="col-12">
                        <hr>
                        <h5>Sibling 2</h5>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sibling 2 Name</label>
                        <input type="text" class="form-control" name="sibling2_name" value="{{ old('sibling2_name', $enquiry->sibling2_name) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sibling 2 Sex</label>
                        <select name="sibling2_sex" class="form-select">
                            <option value="">Select</option>
                            @foreach(['Male', 'Female', 'Other'] as $sex)
                                <option value="{{ $sex }}" {{ $enquiry->sibling2_sex == $sex ? 'selected' : '' }}>{{ $sex }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sibling 2 DOB</label>
                        <input type="date" class="form-control" name="sibling2_dob" value="{{ old('sibling2_dob', $enquiry->sibling2_dob) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="2">{{ old('address', $enquiry->address) }}</textarea>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" name="state" value="{{ old('state', $enquiry->state) }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" value="{{ old('city', $enquiry->city) }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Pin</label>
                        <input type="text" class="form-control" name="pin" value="{{ old('pin', $enquiry->pin) }}">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('enquiries.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

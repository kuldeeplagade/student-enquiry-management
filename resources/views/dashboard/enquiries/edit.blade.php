<!DOCTYPE html>
<html>
<head>
    <title>Edit Enquiry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 700px;">
    <h2 class="mb-4">Edit Enquiry</h2>

    <form action="{{ route('enquiries.update', $enquiry->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Name Details --}}
        <div class="row mb-3">
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
        </div>

        {{-- DOB, Sex, Blood Group --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">DOB</label>
                <input type="date" class="form-control" name="dob" value="{{ old('dob', $enquiry->dob) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Sex</label>
                <select class="form-select" name="sex" required>
                    @foreach(['Male', 'Female', 'Other'] as $option)
                        <option value="{{ $option }}" {{ old('sex', $enquiry->sex) == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Blood Group</label>
                <input type="text" class="form-control" name="blood_group" value="{{ old('blood_group', $enquiry->blood_group) }}">
            </div>
        </div>

        {{-- Contact --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Father Mobile</label>
                <input type="text" class="form-control" name="father_mobile" value="{{ old('father_mobile', $enquiry->father_mobile) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Mother Mobile</label>
                <input type="text" class="form-control" name="mother_mobile" value="{{ old('mother_mobile', $enquiry->mother_mobile) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Landline</label>
                <input type="text" class="form-control" name="landline" value="{{ old('landline', $enquiry->landline) }}">
            </div>
        </div>

        {{-- Email & Admission --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $enquiry->email) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Admission For</label>
                <select class="form-select" name="admission_for" required>
                    @foreach(['Playgroup', 'Nursery', 'Jr.KG', 'Sr.KG'] as $class)
                        <option value="{{ $class }}" {{ old('admission_for', $enquiry->admission_for) == $class ? 'selected' : '' }}>{{ $class }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Sibling 1 --}}
        <h5 class="mt-4">Sibling 1</h5>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="sibling1_name" value="{{ old('sibling1_name', $enquiry->sibling1_name) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sex</label>
                <select class="form-select" name="sibling1_sex">
                    <option value="">Select</option>
                    @foreach(['Male', 'Female', 'Other'] as $option)
                        <option value="{{ $option }}" {{ old('sibling1_sex', $enquiry->sibling1_sex) == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">DOB</label>
                <input type="date" class="form-control" name="sibling1_dob" value="{{ old('sibling1_dob', $enquiry->sibling1_dob) }}">
            </div>
        </div>

        {{-- Sibling 2 --}}
        <h5 class="mt-4">Sibling 2</h5>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="sibling2_name" value="{{ old('sibling2_name', $enquiry->sibling2_name) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sex</label>
                <select class="form-select" name="sibling2_sex">
                    <option value="">Select</option>
                    @foreach(['Male', 'Female', 'Other'] as $option)
                        <option value="{{ $option }}" {{ old('sibling2_sex', $enquiry->sibling2_sex) == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">DOB</label>
                <input type="date" class="form-control" name="sibling2_dob" value="{{ old('sibling2_dob', $enquiry->sibling2_dob) }}">
            </div>
        </div>

        {{-- Address --}}
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address" rows="2">{{ old('address', $enquiry->address) }}</textarea>
        </div>

        {{-- Location --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label">State</label>
                <input type="text" class="form-control" name="state" value="{{ old('state', $enquiry->state) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="city" value="{{ old('city', $enquiry->city) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Pin</label>
                <input type="text" class="form-control" name="pin" value="{{ old('pin', $enquiry->pin) }}">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Update Enquiry</button>
            <a href="{{ route('enquiries.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>

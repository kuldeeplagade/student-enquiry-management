<?php

namespace App\Http\Controllers;




use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Enquiry;


class EnquiryController extends Controller
{
    //View form 
    public function create()
    {
        return view('public.enquiry.form');
    }

    //Store Studen Details 
    public function store(Request $request)
    {
    $request->validate([
        'surname' => 'required|string|max:100',
        'first_name' => 'required|string|max:100',
        'middle_name' => 'nullable|string|max:100',
        'dob' => 'required|date',

        'sex' => 'required|in:Male,Female,Other',
        'blood_group' => 'nullable|string|max:10',

        'father_mobile' => 'required|digits:10',
        'mother_mobile' => 'nullable|digits:10', // This expects exactly 10 digits if provided
        'landline' => 'nullable|string|max:15',
        'email' => 'nullable|email|max:100',

        'sibling1_name' => 'nullable|string|max:100',
        'sibling1_sex' => 'nullable|in:Male,Female,Other',
        'sibling1_dob' => 'nullable|date',

        'sibling2_name' => 'nullable|string|max:100',
        'sibling2_sex' => 'nullable|in:Male,Female,Other',
        'sibling2_dob' => 'nullable|date',

        'address' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:100',
        'city' => 'nullable|string|max:100',
        'pin' => 'nullable|string|max:10',
    ], [
        'dob.required' => 'Date of Birth is required.',
        'mother_mobile.digits' => 'Mother mobile must be exactly 10 digits.',
    ]);

        Enquiry::create($request->all());

        return redirect()->back()->with('success', 'Enquiry submitted successfully!');
    }


    //Show Studen details by it id 
    public function show($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        return view('dashboard.enquiries.show', compact('enquiry'));
    }

    //Get All Enquiries  
    public function index(Request $request)
    {
        $selectedClass = $request->get('class', 'All');
        $classes = ['Playgroup', 'Nursery', 'Jr.KG', 'Sr.KG'];

        $enquiries = Enquiry::when($selectedClass !== 'All', function ($query) use ($selectedClass) {
            return $query->where('admission_for', $selectedClass);
        })->get();

        return view('dashboard.enquiries.index', compact('enquiries', 'classes', 'selectedClass'));
    }

    //View Enquiry by id for update 
    public function edit($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        return view('dashboard.enquiries.edit', compact('enquiry'));
    }

    //Update Enquiry by id 
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'surname' => 'required|string',
                'first_name' => 'required|string',
                'middle_name' => 'nullable|string',
                'dob' => 'required|date',
                'sex' => 'required|in:Male,Female,Other',
                'blood_group' => 'nullable|string',
                'father_mobile' => 'required|string',
                'mother_mobile' => 'nullable|string',
                'landline' => 'nullable|string',
                'email' => 'nullable|email',
                'admission_for' => 'required|in:Playgroup,Nursery,Jr.KG,Sr.KG',
                'sibling1_name' => 'nullable|string',
                'sibling1_sex' => 'nullable|in:Male,Female,Other',
                'sibling1_dob' => 'nullable|date',
                'sibling2_name' => 'nullable|string',
                'sibling2_sex' => 'nullable|in:Male,Female,Other',
                'sibling2_dob' => 'nullable|date',
                'address' => 'nullable|string',
                'state' => 'nullable|string',
                'city' => 'nullable|string',
                'pin' => 'nullable|string',

                // Payment-related fields
                'payment_status' => 'nullable|in:Pending,Payment Started',
                'payment_mode' => 'nullable|in:Cash,UPI,Bank Transfer',
                'amount_paid' => 'nullable|numeric|min:0',
                'total_amount' => 'nullable|numeric|min:0',
            ]);

            $enquiry = Enquiry::findOrFail($id);
            $enquiry->update($request->all());

            return redirect()->route('enquiries.index')->with('success', 'Enquiry updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Enquiry update failed: '.$e->getMessage());
            return back()->with('error', 'Something went wrong while updating enquiry.');
        }
    }

}

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
        'branch_name' => ['required', Rule::in(['Mumbai Branch 1', 'Mumbai Branch 2'])], //Addded Two default branch after chnage this in actual name  

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

        $defaultFees = [
            'Playgroup' => 15000,
            'Nursery' => 13000,
            'Jr.KG' => 14000,
            'Sr.KG' => 14500,
            'Day Care' => 10000,
        ];

        $data = $request->all();
        $data['default_fee'] = $defaultFees[$request->admission_for] ?? 0;
        $data['discount_amount'] = $request->discount_amount ?? 0;

        Enquiry::create($data);


        return redirect()->back()->with('success', 'Enquiry submitted successfully!');
    }


    //Show Studen details by it id 
    public function show($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        return view('dashboard.enquiries.show', compact('enquiry'));
    }

    // Get All Enquiries  
    public function index(Request $request)
    {
        $selectedClass = $request->get('class', 'All');
        $selectedBranch = $request->get('branch_name', 'All');
        $search = $request->get('search');

        $classes = ['Playgroup', 'Nursery', 'Jr.KG', 'Sr.KG', 'Day Care'];
        $branches = ['Mumbai Branch 1', 'Mumbai Branch 2'];

        $enquiries = Enquiry::when($selectedClass !== 'All', function ($query) use ($selectedClass) {
                return $query->where('admission_for', $selectedClass);
            })
            ->when($selectedBranch !== 'All', function ($query) use ($selectedBranch) {
                return $query->where('branch_name', $selectedBranch);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('surname', 'like', "%{$search}%")
                    ->orWhere('father_mobile', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('dashboard.enquiries.index', compact(
            'enquiries',
            'classes',
            'branches',
            'selectedClass',
            'selectedBranch',
            'search'
        ));
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
                'branch_name' => ['required', Rule::in(['Mumbai Branch 1', 'Mumbai Branch 2'])],
                'admission_for' => 'required|in:Playgroup,Nursery,Jr.KG,Sr.KG,Day Care',
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
            ]);

            $enquiry = Enquiry::findOrFail($id);
            $enquiry->update($request->all());

   
            return redirect()->route('enquiries.index')->with('success', 'Enquiry updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Enquiry update failed: '.$e->getMessage());
            return back()->with('error', 'Something went wrong while updating enquiry.');
        }
    }

    public function confirmedAdmissions(Request $request)
    {
        $selectedClass = $request->get('class', 'All');
        $selectedBranch = $request->get('branch_name', 'All');
        $search = $request->get('search');

        $classes = ['Playgroup', 'Nursery', 'Jr.KG', 'Sr.KG', 'Day Care'];
        $branches = ['Mumbai Branch 1', 'Mumbai Branch 2'];

        $enquiries = Enquiry::where(function ($query) {
                $query->where('discount_amount', '>', 0)
                    ->orWhereHas('payments');
            })
            ->when($selectedClass !== 'All', function ($query) use ($selectedClass) {
                return $query->where('admission_for', $selectedClass);
            })
            ->when($selectedBranch !== 'All', function ($query) use ($selectedBranch) {
                return $query->where('branch_name', $selectedBranch);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('surname', 'like', "%{$search}%")
                    ->orWhere('father_mobile', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%");
                });
            })
            ->with('payments')
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('dashboard.enquiries.confirmed', compact(
            'enquiries',
            'classes',
            'branches',
            'selectedClass',
            'selectedBranch',
            'search'
        ));
    }

    //Delete enquiry 
    public function destroy($id)
    {
        $enquiry = Enquiry::findOrFail($id);

        if ($enquiry->discount_amount == 0 && $enquiry->payments()->count() == 0) {
            $enquiry->delete();
            return redirect()->route('enquiries.index')->with('success', 'Enquiry deleted successfully.');
        }

        return redirect()->route('enquiries.confirmed')->with('error', 'Cannot delete confirmed admission.');
    }




}

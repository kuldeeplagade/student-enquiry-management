<?php

namespace App\Http\Controllers;




use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Enquiry;


class EnquiryController extends Controller
{
    public function create()
    {
        return view('public.enquiry.form');
    }


    public function store(Request $request)
    {
        $request->validate([
            'candidate_name' => 'required|string',
            'dob' => 'required|date',
            'parent_contact' => [
                'required',
                'regex:/^[0-9]{10}$/',
                Rule::unique('enquiries')->where(function ($query) use ($request) {
                    return $query->where('admission_for', $request->admission_for);
                }),
            ],
            'admission_for' => 'required|in:Playgroup,Nursery,Jr.KG,Sr.KG',
        ], [
            'parent_contact.regex' => 'Parent contact must be exactly 10 digits.',
            'parent_contact.unique' => 'This parent contact already enquired for the selected class.',
        ]);
    
        Enquiry::create($request->all());
    
        return redirect()->back()->with('success', 'Enquiry submitted successfully!');
    }

    //Enquirie GET , Update 
    public function index(Request $request)
    {
        $classes = ['Playgroup', 'Nursery', 'Jr.KG', 'Sr.KG'];
        $selectedClass = $request->query('class', 'All');

        if ($selectedClass != 'All' && in_array($selectedClass, $classes)) {
            $enquiries = Enquiry::where('admission_for', $selectedClass)->get();
        } else {
            $enquiries = Enquiry::all();
        }

        return view('enquiry.index', compact('enquiries', 'classes', 'selectedClass'));
    }

    

    public function edit($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        return view('enquiry.edit', compact('enquiry'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'candidate_name' => 'required|string',
            'dob' => 'required|date',
            'parent_contact' => 'required|string',
            'admission_for' => 'required|in:Playgroup,Nursery,Jr.KG,Sr.KG',
        ]);

        $enquiry = Enquiry::findOrFail($id);
        $enquiry->update($request->all());

        return redirect()->route('enquiries.index')->with('success', 'Enquiry updated successfully!');
    }

}

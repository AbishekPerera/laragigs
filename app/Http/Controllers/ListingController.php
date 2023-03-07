<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //show all listings
    public function index()
    {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->simplePaginate(6)
        ]);
    }

    //show single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //create form
    public function create()
    {
        return view('listings.create');
    }

    // /store listing data 
    public function store(Request $request)
    {
        //    dd($request->file('logo')->store());
        $formField = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company'),
            ],
            'description' => 'required',
            'tags' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => 'required|email',
            // 'email' => ['required','email'],
        ]);

        if ($request->hasFile('logo')) {
            $formField['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formField['user_id'] = auth()->id();

        // dd($formField);
        Listing::create($formField);

        return redirect('/')->with('success', 'Listing created successfully!');
    }

    //show edit form
    public function edit(Listing $listing)
    {
        // dd($listing);
        return view('listings.edit', [
            'listing' => $listing
        ]);
    }

    //update listing
    public function update(Request $request, Listing $listing)
    {

        // make sure ;login user is the owner
        if ($listing->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to edit this listing!');
        }

        $formField = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')->ignore($listing->id),
            ],
            'description' => 'required',
            'tags' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => 'required|email',
            // 'email' => ['required','email'],
        ]);

        if ($request->hasFile('logo')) {
            $formField['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formField);

        return back()->with('success', 'Listing updated successfully!');
    }

    //delete listing
    public function destroy(Listing $listing)
    {
        // make sure ;login user is the owner
        if ($listing->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to edit this listing!');
        }
        
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!');
    }

    //manage listing
    public function manage()
    {
        return view('listings.manage', [
            'listings' => Listing::where('user_id', auth()->id())->get()
        ]);
    
        // return view('listings.manage', [
        //     'listings' => auth()->user()->listings()->get()
        // ]);
    
    }
}
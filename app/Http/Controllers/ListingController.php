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
    //    dd($request->all());
        $formField = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings','company'),],
            'description' => 'required',
            'tags' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => 'required|email',
            // 'email' => ['required','email'],
        ]);

        Listing::create($formField);

        return redirect('/')->with('success', 'Listing created successfully!');
    }
}

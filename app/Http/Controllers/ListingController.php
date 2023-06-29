<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(){
        return view('listings.index', [

            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(4)
        ]);
    }
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }
    public function create(){
        return view('listings.create');
    }
    public function store(Request $request){
        $formFields=$request->validate([
            'title'=>'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'description' => 'required',
            'tags' => 'required'

        ]);
        if($request->hasFile('logo')){
            $formFields['logo']=$request->file('logo')->store('logos','public');
        }
        $formFields['user_id'] = auth()->id();
        
        Listing::create($formFields);
        
        return redirect('/')->with('message','Successfully posted a job');
    }
    public function edit(Listing $listing){
        return view(('listings.edit'), ['listing' => $listing]);
    }
    public function update(Request $request, Listing $listing)
    {
        if($listing['user_id']!=auth()->id()){
            abort(403,'Unauthorized');
        }
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'description' => 'required',
            'tags' => 'required'

        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        
        
        $listing->update($formFields);

        return back()->with('message', 'Successfully updated a job');
    }
    public function destroy(Listing $listing){
        if ($listing['user_id'] != auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $listing->delete();
        return redirect('/')->with('message','Successfully deleted a listing');
    }
    public function manage(){
        return view('listings.manage',['listings'=>auth()->user()->listings()->get()]);
    }
}

<?php

namespace Modules\Contacts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Contacts\App\Models\Contact;
use Modules\Contacts\App\Http\Requests\Contact\CreateRequest;
use Modules\Contacts\App\Http\Requests\Contact\UpdateRequest;
use Modules\Contacts\App\Http\Resources\CategoryResource;
use Inertia\Inertia;
use Storage;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::select('id','name','type');


        if ($request->has('search')) {
            $query = $query->where('name','LIKE','%'.$request->get('search').'%');
        }

        $contacts = $query->withCount(['sales','purchases'])->paginate(6);
        return Inertia::render('Contacts::Index',[
            'contacts' => $contacts,
            'search' => $request->get('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Contacts::Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        if ($request->default_on_sales == 1) {
            Contact::where('id','!=',$contact->id)->update(['default_on_sales' => 0]);
        }

        if ($request->default_on_purchases == 1) {
            Contact::where('id','!=',$contact->id)->update(['default_on_purchases' => 0]);
        }

        $save = Contact::insert($request->validated());
        if ($save) {
            return redirect()->route('contacts.index')->with('success','alerts.added_successfully');
        }
        return redirect()->route('contacts.create')->with('error','alerts.added_error');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return Inertia::render('Contacts::Edit' , compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Contact $contact)
    {
        if ($request->default_on_sales == 1) {
            Contact::where('id','!=',$contact->id)->update(['default_on_sales' => 0]);
        }

        if ($request->default_on_purchases == 1) {
            Contact::where('id','!=',$contact->id)->update(['default_on_purchases' => 0]);
        }

        $save = $contact->update($request->validated());
        if ($save) {
            return redirect()->route('contacts.index')->with('success','alerts.edited_successfully');
        }
        return redirect()->route('contacts.create')->with('error','alerts.edited_error');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->loadCount(['sales', 'purchases']);
        if ($contact->sales_count > 0 || $contact->purchases_count > 0) 
            return redirect()->route('contacts.index')->with('error','alerts.cannot_delete_contact_error');

        $delete = $contact->delete();
        if ($delete) {
            return redirect()->route('contacts.index')->with('success','alerts.deleted_successfully');
        }

        return redirect()->route('contacts.index')->with('error','alerts.deleted_error');
    }
}

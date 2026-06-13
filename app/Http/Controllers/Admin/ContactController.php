<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.contacts.index', ['contacts' => Contact::latest()->paginate(30)]);
    }

    public function show(Contact $contact)
    {
        $contact->update(['status' => 'read', 'read_at' => $contact->read_at ?? now()]);

        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', __('Inquiry deleted.'));
    }
}

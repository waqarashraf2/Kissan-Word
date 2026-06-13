<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store(StoreContactRequest $request)
    {
        Contact::create($request->validated());

        return back()->with('success', __('Thank you. We will contact you soon.'));
    }
}

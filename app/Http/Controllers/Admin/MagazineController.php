<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MagazineRequest;
use App\Models\Magazine;

class MagazineController extends Controller
{
    public function index()
    {
        return view('admin.magazines.index', ['magazines' => Magazine::latest()->paginate(20)]);
    }

    public function create()
    {
        return view('admin.magazines.create');
    }

    public function store(MagazineRequest $request)
    {
        $magazine = Magazine::create($request->validated());

        return redirect()->route('admin.magazines.edit', $magazine)->with('success', __('Magazine created.'));
    }

    public function edit(Magazine $magazine)
    {
        return view('admin.magazines.edit', compact('magazine'));
    }

    public function update(MagazineRequest $request, Magazine $magazine)
    {
        $magazine->update($request->validated());

        return back()->with('success', __('Magazine updated.'));
    }

    public function destroy(Magazine $magazine)
    {
        $magazine->delete();

        return redirect()->route('admin.magazines.index')->with('success', __('Magazine deleted.'));
    }
}

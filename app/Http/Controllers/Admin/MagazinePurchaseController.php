<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MagazinePurchase;
use Illuminate\Http\Request;

class MagazinePurchaseController extends Controller
{
    public function index()
    {
        return view('admin.magazine-purchases.index', [
            'purchases' => MagazinePurchase::with(['user', 'magazine'])->latest()->paginate(30),
        ]);
    }

    public function update(Request $request, MagazinePurchase $magazinePurchase)
    {
        $data = $request->validate([
            'payment_status' => ['required', 'in:pending,paid,failed,refunded'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
        ]);
        $data['paid_at'] = $data['payment_status'] === 'paid' ? ($magazinePurchase->paid_at ?? now()) : null;
        $magazinePurchase->update($data);

        return back()->with('success', __('Magazine purchase updated.'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Models\MagazinePurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MagazinePurchaseController extends Controller
{
    public function store(Request $request, Magazine $magazine)
    {
        abort_unless($magazine->is_active, 404);
        abort_if($magazine->is_free || (float) $magazine->price === 0.0, 422, 'This magazine is free.');

        $data = $request->validate([
            'payment_method' => ['required', 'in:bank_transfer,cash_deposit'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
        ]);

        $purchase = MagazinePurchase::updateOrCreate(
            ['user_id' => $request->user()->id, 'magazine_id' => $magazine->id],
            [
                'purchase_number' => 'KWM-'.now()->format('Ymd').'-'.Str::upper(Str::random(8)),
                'amount' => $magazine->price,
                'payment_method' => $data['payment_method'],
                'payment_reference' => $data['payment_reference'] ?? null,
                'payment_status' => 'pending',
                'paid_at' => null,
            ]
        );

        return redirect()->route('magazines.show', $magazine)
            ->with('success', __('Purchase request :number submitted.', ['number' => $purchase->purchase_number]));
    }
}

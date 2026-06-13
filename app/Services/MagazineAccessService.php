<?php

namespace App\Services;

use App\Models\Magazine;
use App\Models\User;

class MagazineAccessService
{
    public function canAccess(?User $user, Magazine $magazine): bool
    {
        if (! $magazine->is_active) {
            return false;
        }

        if ($magazine->is_free || (float) $magazine->price === 0.0) {
            return true;
        }

        return $user?->magazinePurchases()
            ->where('magazine_id', $magazine->id)
            ->where('payment_status', 'paid')
            ->exists() ?? false;
    }
}

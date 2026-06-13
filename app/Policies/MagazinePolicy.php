<?php

namespace App\Policies;

use App\Models\Magazine;
use App\Models\User;
use App\Services\MagazineAccessService;

class MagazinePolicy
{
    public function viewPdf(?User $user, Magazine $magazine): bool
    {
        return app(MagazineAccessService::class)->canAccess($user, $magazine);
    }

    public function download(?User $user, Magazine $magazine): bool
    {
        return $magazine->allow_download && $this->viewPdf($user, $magazine);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['schema_markup' => 'array', 'noindex' => 'boolean'];
    }
}

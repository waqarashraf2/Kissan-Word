<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Magazine extends Model
{
    use HasFactory, HasUniqueSlug, SoftDeletes;

    protected string $slugSource = 'title';

    protected $attributes = [
        'price' => 0,
        'is_free' => false,
        'allow_download' => true,
        'is_active' => true,
    ];

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_free' => 'boolean',
            'allow_download' => 'boolean',
            'is_active' => 'boolean',
            'issue_date' => 'date',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(MagazinePurchase::class);
    }
}

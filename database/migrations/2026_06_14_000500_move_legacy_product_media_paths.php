<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('product_images')
            ->where('path', 'like', 'products/demo/%')
            ->orderBy('id')
            ->eachById(function ($image): void {
                DB::table('product_images')
                    ->where('id', $image->id)
                    ->update([
                        'path' => preg_replace('#^products/demo/#', 'product-media/demo/', $image->path),
                    ]);
            });
    }

    public function down(): void
    {
        DB::table('product_images')
            ->where('path', 'like', 'product-media/demo/%')
            ->orderBy('id')
            ->eachById(function ($image): void {
                DB::table('product_images')
                    ->where('id', $image->id)
                    ->update([
                        'path' => preg_replace('#^product-media/demo/#', 'products/demo/', $image->path),
                    ]);
            });
    }
};

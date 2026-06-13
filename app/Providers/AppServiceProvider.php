<?php

namespace App\Providers;

use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view): void {
            static $settings;

            if ($settings === null && Schema::hasTable('website_settings')) {
                $settings = Cache::remember('public_website_settings', now()->addHour(), fn () => WebsiteSetting::query()
                    ->where('is_public', true)
                    ->pluck('value', 'key')
                    ->all());
            }

            $view->with('siteSettings', $settings ?? []);
        });
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', [
            'websiteSettings' => WebsiteSetting::orderBy('group')->get()->groupBy('group'),
            'seoSettings' => SeoSetting::orderBy('page_key')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'website' => ['nullable', 'array'],
            'website.*' => ['nullable', 'string', 'max:5000'],
            'seo' => ['nullable', 'array'],
            'seo.*.title' => ['required', 'string', 'max:255'],
            'seo.*.meta_description' => ['nullable', 'string', 'max:500'],
            'seo.*.canonical_url' => ['nullable', 'url', 'max:255'],
            'seo.*.noindex' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($data): void {
            foreach ($data['website'] ?? [] as $key => $value) {
                WebsiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
            foreach ($data['seo'] ?? [] as $pageKey => $seo) {
                SeoSetting::updateOrCreate(['page_key' => $pageKey], $seo);
            }
        });

        Cache::forget('public_website_settings');

        return back()->with('success', __('Settings updated.'));
    }
}

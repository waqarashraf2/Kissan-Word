@extends('layouts.admin')
@section('title', 'Settings & SEO')
@section('heading', 'Settings & SEO')
@section('content')
<div class="admin-page-heading"><div><h1>Website settings</h1><p>Contact information, social links, About Us content and page SEO.</p></div></div>
<form action="{{ route('admin.settings.update') }}" method="POST" class="admin-form-stack">@csrf @method('PUT')
@forelse($websiteSettings as $group=>$settings)
<section class="admin-form-card"><div class="admin-card-head"><div><h2>{{ str($group)->replace('_',' ')->title() }}</h2></div></div><div class="admin-field-grid">
@foreach($settings as $setting)
<label class="{{ $setting->type === 'textarea' ? 'admin-span-2' : '' }}">{{ str($setting->key)->replace('_',' ')->title() }}
@if($setting->type === 'textarea')<textarea name="website[{{ $setting->key }}]" rows="5">{{ old('website.'.$setting->key,$setting->value) }}</textarea>
@else<input type="{{ in_array($setting->type,['email','url','number']) ? $setting->type : 'text' }}" name="website[{{ $setting->key }}]" value="{{ old('website.'.$setting->key,$setting->value) }}">@endif
</label>
@endforeach
</div></section>
@empty
<section class="admin-form-card"><p>No website settings exist yet. Run the KISANWORLD content seeder first.</p></section>
@endforelse
<section class="admin-form-card"><div class="admin-card-head"><div><h2>Page SEO</h2><p>Static page title, description, canonical URL and indexing preference.</p></div></div>
@forelse($seoSettings as $seo)<fieldset class="admin-seo-row"><legend>{{ str($seo->page_key)->replace('_',' ')->title() }}</legend><div class="admin-field-grid"><label>Title<input name="seo[{{ $seo->page_key }}][title]" value="{{ old('seo.'.$seo->page_key.'.title',$seo->title) }}" required></label><label>Canonical URL<input type="url" name="seo[{{ $seo->page_key }}][canonical_url]" value="{{ old('seo.'.$seo->page_key.'.canonical_url',$seo->canonical_url) }}"></label><label class="admin-span-2">Meta description<textarea name="seo[{{ $seo->page_key }}][meta_description]" rows="3">{{ old('seo.'.$seo->page_key.'.meta_description',$seo->meta_description) }}</textarea></label><label class="admin-check-field"><input type="hidden" name="seo[{{ $seo->page_key }}][noindex]" value="0"><input type="checkbox" name="seo[{{ $seo->page_key }}][noindex]" value="1" @checked(old('seo.'.$seo->page_key.'.noindex',$seo->noindex))> Noindex this page</label></div></fieldset>
@empty<p>No static SEO records have been created yet.</p>@endforelse
</section>
<div class="admin-form-actions"><button class="admin-primary">Save Settings</button></div>
</form>
@endsection

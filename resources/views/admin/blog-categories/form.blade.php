@php($editingCategory=$category ?? null)
<section class="admin-form-card"><div class="admin-field-grid">
<label>Language<select name="language"><option value="en" @selected(old('language',$editingCategory?->language ?? 'en')==='en')>English</option><option value="ur" @selected(old('language',$editingCategory?->language)==='ur')>Urdu</option></select></label>
<label class="admin-check-field"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$editingCategory?->is_active ?? true))> Active</label>
<label>Name<input name="name" value="{{ old('name',$editingCategory?->name) }}" required></label><label>Urdu name<input name="name_ur" value="{{ old('name_ur',$editingCategory?->name_ur) }}" dir="rtl"></label>
<label class="admin-span-2">Slug<input name="slug" value="{{ old('slug',$editingCategory?->slug) }}"></label><label class="admin-span-2">Description<textarea name="description" rows="5">{{ old('description',$editingCategory?->description) }}</textarea></label>
</div></section>

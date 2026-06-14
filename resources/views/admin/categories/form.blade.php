@php($editingCategory=$category ?? null)
<section class="admin-form-card"><div class="admin-field-grid">
<label>Parent category<select name="parent_id"><option value="">Top level</option>@foreach($parents as $parent)<option value="{{ $parent->id }}" @selected(old('parent_id',$editingCategory?->parent_id)==$parent->id)>{{ $parent->name }}</option>@endforeach</select></label>
<label>Sort order<input type="number" min="0" name="sort_order" value="{{ old('sort_order',$editingCategory?->sort_order ?? 0) }}"></label>
<label>Name<input name="name" value="{{ old('name',$editingCategory?->name) }}" required></label><label>Urdu name<input name="name_ur" dir="rtl" value="{{ old('name_ur',$editingCategory?->name_ur) }}"></label>
<label class="admin-span-2">Slug<input name="slug" value="{{ old('slug',$editingCategory?->slug) }}"></label><label class="admin-span-2">Description<textarea name="description" rows="5">{{ old('description',$editingCategory?->description) }}</textarea></label>
<label>Image path<input name="image" value="{{ old('image',$editingCategory?->image) }}"></label><label class="admin-check-field"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$editingCategory?->is_active ?? true))> Active</label>
<label>Meta title<input name="meta_title" value="{{ old('meta_title',$editingCategory?->meta_title) }}"></label><label>Canonical URL<input type="url" name="canonical_url" value="{{ old('canonical_url',$editingCategory?->canonical_url) }}"></label><label class="admin-span-2">Meta description<textarea name="meta_description" rows="3">{{ old('meta_description',$editingCategory?->meta_description) }}</textarea></label>
</div></section>

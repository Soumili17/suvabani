@push('styles')
<style>
.admin-form{max-width:760px;display:grid;gap:16px}.admin-form label{display:block;font-weight:600;margin-bottom:6px;color:#173b63}.admin-form input,.admin-form textarea{width:100%;padding:11px;border:1px solid #d6e0eb;border-radius:8px}.admin-form img{max-width:300px;border-radius:10px;margin-top:8px}.check-row{display:flex;gap:8px;align-items:center}.check-row input{width:auto}
</style>
@endpush
<div><label>Title</label><input name="title" value="{{ old('title', $banner->title ?? '') }}"></div>
<div><label>Subtitle</label><textarea name="subtitle" rows="3">{{ old('subtitle', $banner->subtitle ?? '') }}</textarea></div>
<div><label>Button text</label><input name="button_text" value="{{ old('button_text', $banner->button_text ?? '') }}" placeholder="Donate now"></div>
<div><label>Button URL</label><input name="button_url" value="{{ old('button_url', $banner->button_url ?? '') }}" placeholder="/donate"></div>
<div><label>Banner image</label><input name="image" type="file" accept="image/jpeg,image/png,image/webp" {{ isset($banner) ? '' : 'required' }}>@if(isset($banner))<img src="{{ asset('storage/'.$banner->image_path) }}" alt="Current banner">@endif</div>
<div><label>Display order</label><input name="display_order" type="number" min="0" value="{{ old('display_order', $banner->display_order ?? 0) }}"></div>
<label class="check-row"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $banner->is_active ?? true))> Show this banner on the homepage</label>

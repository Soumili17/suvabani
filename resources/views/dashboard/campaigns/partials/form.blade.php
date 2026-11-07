@php
    $value = fn ($field, $default = '') => old($field, $campaign?->{$field} ?? $default);
@endphp

<div style="display:grid; gap:16px; margin-bottom:20px;">
    <div>
        <label for="title" style="display:block; font-weight:600; margin-bottom:6px;">Title</label>
        <input id="title" name="title" type="text" value="{{ $value('title') }}" required maxlength="255"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        @error('title') <p style="color:#b42318;">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="slug" style="display:block; font-weight:600; margin-bottom:6px;">URL slug</label>
        <input id="slug" name="slug" type="text" value="{{ $value('slug') }}" required maxlength="255"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        @error('slug') <p style="color:#b42318;">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="category_id" style="display:block; font-weight:600; margin-bottom:6px;">Category</label>
        <select id="category_id" name="category_id" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
            <option value="">No category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) $value('category_id') === (string) $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <p style="color:#b42318;">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="short_description" style="display:block; font-weight:600; margin-bottom:6px;">Short description</label>
        <textarea id="short_description" name="short_description" rows="2" maxlength="255"
                  style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">{{ $value('short_description') }}</textarea>
        @error('short_description') <p style="color:#b42318;">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="description" style="display:block; font-weight:600; margin-bottom:6px;">Full description</label>
        <textarea id="description" name="description" rows="6"
                  style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">{{ $value('description') }}</textarea>
        @error('description') <p style="color:#b42318;">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="goal_amount_rupees" style="display:block; font-weight:600; margin-bottom:6px;">Fundraising goal (₹)</label>
        <input id="goal_amount_rupees" name="goal_amount_rupees" type="number" min="0" step="0.01"
               value="{{ old('goal_amount_rupees', $campaign ? number_format($campaign->goal_amount / 100, 2, '.', '') : '') }}" required
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        @error('goal_amount_rupees') <p style="color:#b42318;">{{ $message }}</p> @enderror
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px;">
        <div>
            <label for="start_date" style="display:block; font-weight:600; margin-bottom:6px;">Start date</label>
            <input id="start_date" name="start_date" type="date" value="{{ substr((string) $value('start_date'), 0, 10) }}"
                   style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
            @error('start_date') <p style="color:#b42318;">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="end_date" style="display:block; font-weight:600; margin-bottom:6px;">End date</label>
            <input id="end_date" name="end_date" type="date" value="{{ substr((string) $value('end_date'), 0, 10) }}"
                   style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
            @error('end_date') <p style="color:#b42318;">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="cover_media" style="display:block; font-weight:600; margin-bottom:6px;">Cover image</label>
        <input id="cover_media" name="cover_media" type="file" accept="image/jpeg,image/png,image/webp"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        @if($campaign?->cover_media_path)
            <img src="{{ asset('storage/'.$campaign->cover_media_path) }}" alt="Current cover"
                 style="display:block;max-width:220px;margin-top:8px;border-radius:8px;">
        @endif
        <input type="hidden" name="cover_media_path" value="{{ $value('cover_media_path') }}">
        @error('cover_media_path') <p style="color:#b42318;">{{ $message }}</p> @enderror
        @error('cover_media') <p style="color:#b42318;">{{ $message }}</p> @enderror
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
        @foreach([
            'beneficiary_name' => 'Beneficiary name',
            'location' => 'Project location',
            'video_url' => 'Video URL',
            'minimum_donation_amount' => 'Minimum donation (paise)',
        ] as $field => $label)
            <div>
                <label for="{{ $field }}" style="display:block; font-weight:600; margin-bottom:6px;">{{ $label }}</label>
                <input id="{{ $field }}" name="{{ $field }}" type="{{ $field === 'video_url' ? 'url' : ($field === 'minimum_donation_amount' ? 'number' : 'text') }}"
                       value="{{ $value($field) }}" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                @error($field) <p style="color:#b42318;">{{ $message }}</p> @enderror
            </div>
        @endforeach
    </div>

    @foreach([
        'story' => 'Detailed project story',
        'why_funding' => 'Why this project needs funding',
        'fund_utilization' => 'How funds will be utilized',
        'milestones' => 'Milestones or funding breakdown',
    ] as $field => $label)
        <div>
            <label for="{{ $field }}" style="display:block; font-weight:600; margin-bottom:6px;">{{ $label }}</label>
            <textarea id="{{ $field }}" name="{{ $field }}" rows="4"
                      style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">{{ $value($field) }}</textarea>
            @error($field) <p style="color:#b42318;">{{ $message }}</p> @enderror
        </div>
    @endforeach

    <div style="display:flex; gap:20px; flex-wrap:wrap;">
        <input type="hidden" name="is_featured" value="0">
        <label><input type="checkbox" name="is_featured" value="1" @checked($value('is_featured'))> Feature on homepage</label>
        <label>Visibility
            <select name="visibility" style="padding:8px;">
                <option value="public" @selected($value('visibility', 'public') === 'public')>Public</option>
                <option value="private" @selected($value('visibility') === 'private')>Private</option>
            </select>
        </label>
    </div>

    <div>
        <label for="display_order" style="display:block; font-weight:600; margin-bottom:6px;">Display order</label>
        <input id="display_order" name="display_order" type="number" min="0" step="1" value="{{ $value('display_order', 0) }}"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        @error('display_order') <p style="color:#b42318;">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="status" style="display:block; font-weight:600; margin-bottom:6px;">Status</label>
        <select id="status" name="status" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
            @foreach (['draft', 'published', 'paused', 'completed', 'cancelled'] as $status)
                <option value="{{ $status }}" @selected($value('status', 'draft') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        @error('status') <p style="color:#b42318;">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="media" style="display:block; font-weight:600; margin-bottom:6px;">Additional images/videos</label>
        <input id="media" name="media[]" type="file" multiple accept="image/*,video/mp4,video/webm,video/quicktime"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        @error('media') <p style="color:#b42318;">{{ $message }}</p> @enderror
        @if ($campaign?->media?->isNotEmpty())
            <ul style="margin-top:8px;">
                @foreach ($campaign->media as $media)
                    <li>{{ $media->caption ?: basename($media->file_path) }}</li>
                @endforeach
            </ul>
            <p style="font-size:13px; color:#666;">Uploading new media replaces the currently attached media.</p>
        @endif
    </div>
</div>

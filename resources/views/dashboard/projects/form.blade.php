@php $value = fn ($field, $default = '') => old($field, $project?->{$field} ?? $default); @endphp
<form method="POST" action="{{ $project ? route('dashboard.projects.update', $project->id) : route('dashboard.projects.store') }}" enctype="multipart/form-data" style="max-width:760px;">
    @csrf
    @if($project) @method('PUT') @endif
    <label>Project title</label>
    <input class="form-control mb-3" name="title" value="{{ $value('title') }}" required>
    @error('title')<div class="text-danger">{{ $message }}</div>@enderror

    <label>URL slug</label>
    <input class="form-control mb-3" name="slug" value="{{ $value('slug') }}" required>
    @error('slug')<div class="text-danger">{{ $message }}</div>@enderror

    <label>Gallery category</label>
    <input class="form-control mb-3" name="category" value="{{ $value('category') }}" placeholder="e.g. Child Welfare" required>
    <small class="text-muted">The card opens this category in the public Gallery.</small>

    <label class="mt-3">Description</label>
    <textarea class="form-control mb-3" name="description" rows="4">{{ $value('description') }}</textarea>

    <label>Cover image</label>
    <input class="form-control mb-2" type="file" name="image" accept="image/jpeg,image/png,image/webp" {{ $project ? '' : 'required' }}>
    @if($project)<img src="{{ asset('storage/'.$project->image_path) }}" alt="Current cover" style="width:220px;height:120px;object-fit:cover;border-radius:8px;margin-bottom:12px;">@endif
    @error('image')<div class="text-danger">{{ $message }}</div>@enderror

    <label>Display order</label>
    <input class="form-control mb-3" type="number" name="display_order" min="0" value="{{ $value('display_order', 0) }}">

    <label class="d-block mb-3">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked($value('is_active', true))>
        Show this project on the homepage
    </label>

    <button class="btn-action" type="submit">{{ $project ? 'Update Project' : 'Create Project' }}</button>
    <a class="btn-action" href="{{ route('dashboard.projects.index') }}">Cancel</a>
</form>

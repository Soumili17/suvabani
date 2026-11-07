@extends('layouts.dashboard')

@section('content')
<div class="page-heading">
    <div><h2>Projects</h2><p>Manage the projects shown in Recent Projects.</p></div>
    <a class="btn-action" href="{{ route('dashboard.projects.create') }}">Add Project</a>
</div>

<div class="table-wrap">
    <table>
        <thead><tr><th>Cover</th><th>Project</th><th>Category</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($projects as $project)
            <tr>
                <td><img src="{{ asset('storage/'.$project->image_path) }}" alt="{{ $project->title }}" style="width:100px;height:60px;object-fit:cover;border-radius:6px;"></td>
                <td>{{ $project->title }}</td>
                <td>{{ $project->category }}</td>
                <td>{{ $project->display_order }}</td>
                <td>{{ $project->is_active ? 'Visible' : 'Hidden' }}</td>
                <td>
                    <a class="btn-action" href="{{ route('dashboard.projects.edit', $project->id) }}">Edit</a>
                    <form action="{{ route('dashboard.projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn-action danger" type="submit" onclick="return confirm('Delete this project?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No projects added yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="pagination-wrap">{{ $projects->links() }}</div>
@endsection

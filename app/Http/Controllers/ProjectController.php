<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('display_order')->latest('id')->paginate(15);

        return view('dashboard.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image_path'] = $request->file('image')->store('projects', 'public');
        $data['is_active'] = $request->boolean('is_active');

        Project::create($data);

        return redirect()->route('dashboard.projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);

        return view('dashboard.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);
        $data = $this->validated($request, $project);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($project->image_path);
            $data['image_path'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($data);

        return redirect()->route('dashboard.projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        Storage::disk('public')->delete($project->image_path);
        $project->delete();

        return redirect()->route('dashboard.projects.index')->with('success', 'Project deleted successfully.');
    }

    private function validated(Request $request, ?Project $project = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($project?->id)],
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => ($project ? 'nullable' : 'required') . '|image|mimes:jpeg,jpg,png,webp|max:5120',
            'url' => 'nullable|url|max:2048',
            'display_order' => 'nullable|integer|min:0',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignCategory;
use App\Models\CampaignUpdate;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    // List campaigns
    public function index()
    {
        $campaigns = Campaign::with('category')->orderBy('display_order')->paginate(15);
        return view('dashboard.campaigns.index', compact('campaigns'));
    }

    // Show create form
    public function create()
    {
        $categories = CampaignCategory::all();
        return view('dashboard.campaigns.create', compact('categories'));
    }

    // Store new campaign
    public function store(StoreCampaignRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = session('admin_id');

        if ($request->hasFile('cover_media')) {
            $data['cover_media_path'] = $request->file('cover_media')->store('campaigns/covers', 'public');
        }

        unset($data['cover_media']);
        $campaign = Campaign::create($data);

        // Handle media uploads
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store("campaigns/{$campaign->id}", 'public');
                $campaign->media()->create([
                    'media_type' => str_starts_with((string) $file->getMimeType(), 'video/') ? 'video' : 'image',
                    'file_path'  => $path,
                    'caption'    => $request->input('media_captions')[$file->getClientOriginalName()] ?? null,
                ]);
            }
        }

        return redirect()->route('dashboard.campaigns.index')
            ->with('success', 'Campaign created successfully.');
    }

    // Show edit form
    public function edit(Campaign $campaign)
    {
        $categories = CampaignCategory::all();
        $campaign->load('media');
        return view('dashboard.campaigns.edit', compact('campaign', 'categories'));
    }

    // Update campaign
    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_media')) {
            if ($campaign->cover_media_path) {
                Storage::disk('public')->delete($campaign->cover_media_path);
            }

            $data['cover_media_path'] = $request->file('cover_media')->store('campaigns/covers', 'public');
        }

        unset($data['cover_media']);
        $campaign->update($data);

        // Replace media if new files uploaded
        if ($request->hasFile('media')) {
            // Optionally delete old media
            foreach ($campaign->media as $old) {
                Storage::disk('public')->delete($old->file_path);
                $old->delete();
            }
            foreach ($request->file('media') as $file) {
                $path = $file->store("campaigns/{$campaign->id}", 'public');
                $campaign->media()->create([
                    'media_type' => str_starts_with((string) $file->getMimeType(), 'video/') ? 'video' : 'image',
                    'file_path'  => $path,
                    'caption'    => $request->input('media_captions')[$file->getClientOriginalName()] ?? null,
                ]);
            }
        }

        return redirect()->route('dashboard.campaigns.index')
            ->with('success', 'Campaign updated successfully.');
    }

    // Soft delete campaign
    public function destroy(Campaign $campaign)
    {
        if ($campaign->donations()->whereIn('payment_status', ['Paid', 'paid'])->exists()) {
            return back()->with('error', 'Campaigns with successful donations cannot be deleted. Unpublish it instead.');
        }

        $campaign->delete();
        return back()->with('success', 'Campaign deleted.');
    }

    // Publish campaign
    public function publish(Campaign $campaign)
    {
        $campaign->update(['status' => 'published', 'published_at' => now()]);
        return back()->with('success', 'Campaign published.');
    }

    // Unpublish campaign
    public function unpublish(Campaign $campaign)
    {
        $campaign->update(['status' => 'draft', 'published_at' => null]);
        return back()->with('success', 'Campaign unpublished.');
    }

    public function feature(Campaign $campaign)
    {
        $campaign->update(['is_featured' => ! $campaign->is_featured]);

        return back()->with('success', $campaign->is_featured
            ? 'Campaign featured on the homepage.'
            : 'Campaign removed from the homepage.');
    }

    public function updates(Campaign $campaign)
    {
        $updates = $campaign->updates()->latest()->get();

        return view('dashboard.campaigns.updates', compact('campaign', 'updates'));
    }

    public function donors(Campaign $campaign)
    {
        $donors = $campaign->donations()
            ->whereIn('payment_status', ['Paid', 'paid'])
            ->latest('donation_date')
            ->latest()
            ->paginate(25);

        return view('dashboard.campaigns.donors', compact('campaign', 'donors'));
    }

    public function storeUpdate(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store("campaigns/{$campaign->id}/updates", 'public');
        }

        $validated['published_at'] = now();
        unset($validated['image']);
        $campaign->updates()->create($validated);

        return back()->with('success', 'Campaign update published.');
    }

    public function destroyUpdate(CampaignUpdate $update)
    {
        if ($update->image_path) {
            Storage::disk('public')->delete($update->image_path);
        }

        $update->delete();

        return back()->with('success', 'Campaign update deleted.');
    }
}
?>

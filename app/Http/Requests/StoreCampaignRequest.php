<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'category_id' => $this->input('category_id') ?: null,
        ]);

        if ($this->filled('goal_amount_rupees')) {
            $this->merge(['goal_amount' => (int) round((float) $this->input('goal_amount_rupees') * 100)]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'exists:campaign_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:campaigns,slug'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'goal_amount' => ['required', 'integer', 'min:0'],
            'goal_amount_rupees' => ['required', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:draft,published,paused,completed,cancelled'],
            'cover_media_path' => ['nullable', 'string', 'max:255'],
            'cover_media' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'beneficiary_name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'story' => ['nullable', 'string'],
            'why_funding' => ['nullable', 'string'],
            'fund_utilization' => ['nullable', 'string'],
            'milestones' => ['nullable', 'string'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'minimum_donation_amount' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'visibility' => ['required', 'in:public,private'],
            'media' => ['nullable', 'array'],
            'media.*' => ['file', 'mimetypes:image/jpeg,image/png,image/gif,image/webp,video/mp4,video/webm,video/quicktime', 'max:20480'],
        ];
    }
}

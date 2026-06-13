<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        $video = $this->route('video');

        return [
            'category' => ['nullable', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('videos')->ignore($video?->id)],
            'description' => ['nullable', 'string'],
            'youtube_url' => ['required', 'url', 'max:255'],
            'youtube_video_id' => ['required', 'alpha_dash', 'max:32'],
            'thumbnail' => ['nullable', 'string', 'max:255'],
            'thumbnail_alt' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
        ];
    }
}

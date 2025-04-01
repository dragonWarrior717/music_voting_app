<?php

namespace App\Http\Requests\Album;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'song_name' => ['required', 'string', 'max:255'],
            'artist_name' => ['required', 'string', 'max:255'],
            'cover_image' => ['nullable', 'image', 'max:2048'], // Max 2MB
        ];
    }
} 
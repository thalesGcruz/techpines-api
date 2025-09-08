<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMusicRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'views' => ['sometimes', 'integer', 'min:0'],
            'thumb' => ['sometimes', 'nullable', 'url'],
            'youtube_id' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', 'in:reproved,active,awaiting_approval'],
        ];
    }
}

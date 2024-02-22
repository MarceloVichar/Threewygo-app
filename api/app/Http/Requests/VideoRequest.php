<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\File;

class VideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|min:2|max:255',
            'description' => 'required|string|min:2|max:255',
            'image' => [
                'nullable',
                File::image()
                ->min(1)
                ->max(1024)
            ],
            'course_id' => 'required|integer|exists:courses,id'
        ];

        if ( data_get($this, '_METHOD', 'POST') === 'POST') {
            $rules['video'] = [
                'required',
                File::types(['mp4'])
                    ->min(1)
                    ->max(102400)
            ];
        }

        return $rules;
    }
}

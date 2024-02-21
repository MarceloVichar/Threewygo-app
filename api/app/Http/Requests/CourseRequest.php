<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class CourseRequest extends FormRequest
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
        return [
            'title' => 'required|string|min:2|max:255',
            'description' => 'required|string|min:2|max:255',
            'start_date' => 'required|string|date_format:Y-m-d|afterOrEqual:today',
            'end_date' => 'required|string|date_format:Y-m-d|afterOrEqual:start_date',
            'image' => [
                'nullable',
                File::image()
                    ->min(1)
                    ->max(1024)
            ]
        ];
    }
}

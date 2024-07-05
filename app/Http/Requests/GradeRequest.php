<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
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
            'name' => 'required|string',
            'name_en' => 'required|string',
            'notes' => 'nullable|string',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => trans('dashboard.arabic_grade_name.required'),
            // 'english_name.required' => trans('dashboard.english_grade_name.required'),

        ];
    }
}

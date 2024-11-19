<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSummaryCalendarRequest extends FormRequest
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
        $currentYear = date('Y'); // Obtém o ano atual
        return [
            'course_id' => 'required|exists:courses,id',
            'class_id' => [
            'required',
                Rule::unique('summary_calendar')->where(function ($query) {
                    return $query->where('shift_id', $this->input('shift_id'));
                })
            ],
            'shift_id' => 'required|exists:shifts,id',
            'duration_months' => 'required|integer|min:1',
            'year' => 'required|integer|min:' . $currentYear . '|max:' . ($currentYear + 1),
            'status' => 'required|boolean',
            'schedule' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'class_id.unique' => 'The combination of this class and shift already exists. Please choose a different combination.',
        ];
    }

}

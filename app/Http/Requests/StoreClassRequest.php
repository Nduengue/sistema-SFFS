<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = \App\Models\User::find($value);
                    if ($user && $user->user_type != 3) {
                        $fail('The selected user is not an instructor.');
                    }
                }
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'vacancies' => 'required|integer|min:1|max:500',
            'shift_id' => 'required|exists:shifts,id',
            'obs' => 'nullable|string|max:500'
        ];
    }
}

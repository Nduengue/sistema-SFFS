<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Shift;

class StoreShiftRequest extends FormRequest
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
            'shift_name' => 'required|string|max:15|in:Manhã,Tarde,Noite',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'obs'        => 'nullable|string|max:500',
        ];
    }

    /**
     * Add custom validation logic after rules are applied.
     */
    protected function prepareForValidation()
    {
        // This method is for preparation before the actual validation
    }

    /**
     * Validate that the combination of shift_name, start_time, and end_time is unique.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $existingShift = Shift::where('shift_name', $this->shift_name)
                                  ->where('start_time', $this->start_time)
                                  ->where('end_time', $this->end_time)
                                  ->first();

            if ($existingShift) {
                $validator->errors()->add('shift_name', 'A combinação de nome do turno, hora de início e hora de término já existe.');
            }
        });
    }
}

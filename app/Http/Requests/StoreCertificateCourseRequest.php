<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertificateCourseRequest extends FormRequest
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
            "student_id"=>"required",
            "name_projects"=>"nullable",
            "start"=>"nullable",
            "term1"=>"nullable",
            "hours"=>"required|numeric|min:1",
            "date_start"=>"required|date",
            "date"=>"required|date",
            "academic_year"=>"required",
        ];
    }
}

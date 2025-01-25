<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string', 'max:200'],
            'status' => ['required', 'in:planned,active,finished'],
            'project_start' => ['required', 'date'],
            'project_end' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
        ];
    }
}

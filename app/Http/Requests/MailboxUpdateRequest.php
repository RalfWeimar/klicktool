<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailboxUpdateRequest extends FormRequest
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
            'status' => ['required', 'in:active,inactive'],
            'description' => ['nullable', 'string'],
            'average_time' => ['required', 'integer'],
            'average_pay' => ['required', 'integer'],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'box_id' => ['required', 'integer', 'exists:boxes,id'],
        ];
    }
}

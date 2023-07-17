<?php

namespace App\Http\Requests;

use App\Enum\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'nullable', 'string'],
            'status' => ['required', 'string', 'in:' . implode(',', TaskStatusEnum::values())],
            'parent_id' => ['nullable', 'integer', 'exists:tasks,id'],
        ];
    }
}

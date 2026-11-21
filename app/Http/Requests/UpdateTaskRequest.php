<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'status' => 'sometimes|required|in:new,in_progress,done',
            'project_id' => 'sometimes|required|integer|exists:projects,id',
            'author_id' => 'sometimes|required|integer|exists:users,id',
            'assigned_to' => 'sometimes|nullable|integer|exists:users,id',
            'due_date' => 'sometimes|nullable|date|after_or_equal:today',
        ];
    }
}

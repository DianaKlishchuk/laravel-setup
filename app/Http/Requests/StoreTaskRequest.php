<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:new,in_progress,done',
            'project_id' => 'required|integer|exists:projects,id',
            'author_id' => 'required|integer|exists:users,id',
            'assigned_to' => 'nullable|integer|exists:users,id',
            'due_date' => 'nullable|date|after_or_equal:today',
        ];
    }
}

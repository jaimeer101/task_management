<?php

namespace App\Http\Requests;

use App\Enum\TaskStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('task.update', $this->route('task'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function prepareForValidation(): void
    {
        if (! $this->user()->hasRole('admin')) {
            $this->merge([
                'user_id' => $this->user()->id,
            ]);
        }
    }
    public function rules(): array
    {
        $task = $this->route('task');

        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tasks', 'title')->where(function ($query) {
                    return $query->where('user_id', $this->input('user_id'));
                })->ignore($task),
            ],
            'description' => 'nullable|string', 
            'date_started' => 'required|string',
            'date_completed' => 'nullable|string|before_or_equal:today',
            'date_deadline' => 'nullable|string',
            'task_status' => ['required', new Enum(TaskStatus::class)],
            'user_id' => 'required|exists:users,id',
        ];
    }
}

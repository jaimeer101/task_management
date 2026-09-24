<?php

namespace App\Http\Requests;

use App\Enum\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;


class StoreTaskRequest extends FormRequest
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
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tasks', 'title')->where(function ($query) {
                    return $query->where('user_id', $this->input('user_id'));
                }),
            ],
            'description' => 'required|string',
            'task_status' => ['required', new Enum(TaskStatus::class)], // Validates against your TaskStatus enum[cite: 3]
            'user_id' => 'required|exists:users,id',
        ];
    }
}

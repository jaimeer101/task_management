<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'assigned_user' => $this->user->name, 
            'task_status' => [
                'value' => $this->task_status?->value,
                'label' => $this->task_status?->label(),
                'class' => $this->task_status?->badgeClass(),
            ],
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}

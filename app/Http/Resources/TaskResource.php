<?php

namespace App\Http\Resources;

use App\Enum\TaskStatus;
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
        $isDelayed = $this->date_deadline 
            && $this->date_deadline->isPast() 
            && $this->task_status !== TaskStatus::COMPLETED;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'assigned_user' => $this->user->name, 
            'task_status' => [
                'value' => $this->task_status?->value,
                'label' => $this->task_status?->label(),
                'class' => $this->task_status?->badgeClass(),
            ],
            'date_started' => $this->date_started?->format('F d, Y'),
            'date_completed' => $this->date_completed?->format('F d, Y'),
            'date_deadline' => $this->date_deadline?->format('F d, Y'), 
            'is_delayed' => $isDelayed,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}

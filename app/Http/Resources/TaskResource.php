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
            'name' => $this->name,
            'employee_id' => $this->employee_id,
            'employee' => new EmployeeResource($this->employee),
            'completed_at' => $this->completed_at?->toDayDateTimeString(),
            'created_at' => $this->created_at?->toDayDateTimeString(),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'can' => [
                'update' => $request->user()?->can('tasks-update'),
                'delete' => $request->user()?->can('tasks-delete'),
            ],
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'salary' => $this->salary,
            'created_at' => $this->created_at?->toDayDateTimeString(),
            'department_id' => $this->department_id,
            'manager_id' => $this->manager_id,
            'can' => [
                'update' => $request->user()?->can('employees-update'),
                'delete' => $request->user()?->can('employees-delete'),
            ],
        ];
    }
}

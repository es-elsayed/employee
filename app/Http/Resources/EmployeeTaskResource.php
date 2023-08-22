<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeTaskResource extends JsonResource
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
            'can' => [
                'update' => $request->user()?->hasRole('employee'),
                'delete' => null,
            ],
        ];
    }
}

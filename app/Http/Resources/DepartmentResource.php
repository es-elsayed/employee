<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'description' => substr($this->description, 0, 75),
            'created_at' => $this->created_at?->toDayDateTimeString(),
            'can' => [
                'update' => $request->user()?->can('departments-update'),
                'delete' => $request->user()?->can('departments-delete'),
            ],
        ];
    }
}

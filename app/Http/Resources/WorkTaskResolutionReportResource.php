<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkTaskResolutionReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'resolution_types' => $this->resource->map(fn ($item) => [
                'id' => (int) $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'count' => (int) $item->work_tasks_count,
            ]),
        ];
    }
}

<?php

namespace App\Http\Resources\Api\Note;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->getRouteKey(),
            'type' => $this->resource->model_type,
            'attributes' => [
                'title' => $this->resource->title,
                'content' => $this->resource->content,
                'slug' => $this->resource->slug,
                'is_favorite' => (bool)$this->resource->favorite,
                'created_at' => $this->resource->created_at
            ]
        ];
    }
}

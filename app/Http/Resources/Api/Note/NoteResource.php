<?php

namespace App\Http\Resources\Api\Note;

use App\JsonApi\Traits\JsonApiResource;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NoteResource extends JsonResource
{
    use JsonApiResource;

    public function toJsonApi(): array
    {
        return [
            'title' => $this->resource->title,
            'content' => $this->resource->content,
            'slug' => (string)$this->resource->slug,
            'is_favorite' => (bool)$this->resource->favorite,
            'created_at' => (string)$this->resource->created_at
        ];
    }
}

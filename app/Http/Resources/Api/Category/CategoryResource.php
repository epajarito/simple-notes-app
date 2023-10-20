<?php

namespace App\Http\Resources\Api\Category;

use App\JsonApi\Traits\JsonApiResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    use JsonApiResource;

    public function toJsonApi(): array
    {
        return [
            'name' => $this->resource->name
        ];
    }

}

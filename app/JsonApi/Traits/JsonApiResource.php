<?php

namespace App\JsonApi\Traits;

use App\Http\Resources\Api\Category\CategoryResource;
use App\JsonApi\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

trait JsonApiResource
{
    abstract public function toJsonApi();

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if( request()->filled('include') ){
            $this->with['included'] = $this->getIncludes();
        }


        return Document::type($this->resource->resource_type)
            ->id($this->resource->getRouteKey())
            ->attributes($this->filterAttributes($this->toJsonApi()))
            ->relationshipsLinks($this->getRelationshipLinks())
            ->links([
                'self' => route("api.{$this->resource->resource_type}.show", $this->resource)
            ])
            ->get('data');
    }

    public function getRelationshipLinks(): array
    {
        return [];
    }

    public function withResponse($request, $response)
    {
        $response->header(
            'Location',
            route("api.{$this->resource->resource_type}.show", $this->resource)
        );
    }

    public function filterAttributes(array $attributes): array
    {
        return array_filter($attributes, function ($value){
            if( request()->isNotFilled('fields') ){
                return true;
            }

            $fields = explode(",", request("fields.{$this->resource->resource_type}"));

            if( $value === $this->getRouteKey() ){
                return in_array($this->getRouteKeyName(), $fields);
            }

            return $value;
        });
    }

    public static function collection($resource): AnonymousResourceCollection
    {
        $collection = parent::collection($resource);

        $collection->with['links'] = ['self' => $resource->path()];

        return $collection;
    }

    public function getIncludes(): array
    {
        return [];
    }

}
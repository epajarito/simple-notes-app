<?php

namespace App\JsonApi\Traits;

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

        return Document::type($this->resource->resource_type)
            ->id((string)$this->resource->id)
            ->attributes($this->filterAttributes($this->toJsonApi()))
            ->links([
                'self' => route("api.{$this->resource->resource_type}.show", $this->resource)
            ])
            ->get('data');
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

}
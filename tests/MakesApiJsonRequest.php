<?php

namespace Tests;

use App\JsonApi\Document;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;

trait MakesApiJsonRequest
{
    public bool $formatJsonApiDocument = true;

    /**
     * @param string $uri
     * @param array $data
     * @return array
     */
    public function getFormattedData(string $uri, array $data): array
    {
        $path = parse_url($uri)['path'];
        $type = (string)str($uri)->after('api/')->before('/');
        $id = (string)str($path)->after($type)->replace('/', '');

        return Document::type($type)
            ->id($id)
            ->attributes($data)
            ->relationshipsData($data['_relationships'] ?? [])
            ->toArray();
    }

    protected function setUp(): void
    {
        parent::setUp();
        TestResponse::macro('assertJsonApiResource', function ($model, $attribute){
            /** @var TestResponse $this */
            $this->assertJson([
                'data' => [
                    'type' => $model->resource_type,
                    'id' => $model->slug,
                    'attributes' => $attribute,
                    'links' => [
                        'self' => route("api.{$model->resource_type}.show", $model)
                    ]
                ]
            ])->assertHeader(
                'Location',
                route("api.{$model->resource_type}.show", $model)
            );

            return $this;
        });

        TestResponse::macro('assertJsonApiResourceCollection', function ($models, $attributesKeys){
            /** @var TestResponse $this */

            $this->assertJsonStructure([
                'data' => [
                    '*' => [
                        'attributes' =>  $attributesKeys
                    ]
                ]
            ]);

            foreach ($models as $model){
                $this->assertJsonFragment([
                    'id' => $model->slug,
                    'type' => $model->resource_type,
                    'links' => [
                        'self' => route("api.{$model->resource_type}.show", $model)
                    ]
                ]);
            }
        });

        TestResponse::macro('assertJsonApiValidationErrors', function ($attribute){
            /** @var TestResponse $this */

            $pointer = "/data/attributes/{$attribute}";
            if ( str($attribute)->startsWith('data') ){
                $pointer = "/". str_replace('.', '/', $attribute);
            }else if (str($attribute)->startsWith('relationships')){
                $pointer = "/data/" . str_replace('.', '/', $attribute) . "/data/id";
            }

            try {
                $this->assertJsonFragment([
                    'source' => ['pointer' => $pointer]
                ]);
            }catch (ExpectationFailedException $e){
                PHPUnit::fail(
                    "Failed to find a JSON:API validation error for key: '{$attribute}'"
                    .PHP_EOL.PHP_EOL.
                    $e->getMessage()
                );
            }

            try {
                $this->assertJsonStructure(
                    [
                        'errors' => [
                            ['title', 'detail', 'source' => ['pointer']]
                        ]
                    ]
                );
            }catch (ExpectationFailedException $e){
                PHPUnit::fail(
                    "Failed to find a valid JSON:API error response"
                    .PHP_EOL.PHP_EOL.
                    $e->getMessage()
                );
            }

            $this
                ->assertHeader('content-type', 'application/vnd.api+json')
                ->assertStatus(422);
        });

        TestResponse::macro('assertJsonApiRelationshipLinks', function ($model, $relations){
            /** @var TestResponse $this */
            foreach ($relations as $relation){
                $this->assertJson([
                    'data' => [
                        'relationships' => [
                            'category' => [
                                'links' => [
                                    'self' => route("api.{$model->resource_type}.relationships.{$relation}", $model),
                                    'related' => route("api.{$model->resource_type}.{$relation}", $model),
                                ]
                            ]
                        ]
                    ]
                ]);
            }

            return $this;
        });
    }

    public function withoutJsonApiDocumentFormatting(): void
    {
        $this->formatJsonApiDocument = false;
    }
    public function json($method, $uri, array $data = [], array $headers = [], $options = 0)
    {
        $headers['accept'] = 'application/vnd.api+json';
        if ( $this->formatJsonApiDocument ){
            $formattedData = $this->getFormattedData($uri, $data);
        }

        return parent::json($method, $uri, $formattedData ?? $data, $headers, $options);
    }

    public function postJson($uri, array $data = [], array $headers = [], $options = 0)
    {
        $headers["content-type"] = 'application/vnd.api+json';

        return parent::postJson($uri, $data, $headers, $options);
    }

    public function patchJson($uri, array $data = [], array $headers = [], $options = 0)
    {
        $headers["content-type"] = 'application/vnd.api+json';

        return parent::patchJson($uri, $data, $headers, $options);
    }
}
<?php

use App\Http\Middleware\ValidateJsonApiDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (){
    $this->withoutJsonApiDocumentFormatting();

    Route::any('test-route', fn()=> 'ok')
        ->middleware(ValidateJsonApiDocument::class);
});

it('only accepts valid json api document', function (){
    \Pest\Laravel\postJson(
        'test-route',
        [
            'data' => [
                'type' => 'string',
                'attributes' => [
                    'title' => 'some name'
                ]
            ]
        ]
    )
        ->assertSuccessful();

    \Pest\Laravel\patchJson(
        'test-route',
        [
            'data' => [
                'type' => 'string',
                'id' => '1',
                'attributes' => [
                    'title' => 'some name'
                ]
            ]
        ]
    )
        ->assertSuccessful();
});

it('data is required', function () {
    \Pest\Laravel\postJson(
        'test-route',
        []
    )
        ->assertJsonApiValidationErrors('data');


    \Pest\Laravel\patchJson(
        'test-route',
        []
    )
        ->assertJsonApiValidationErrors('data');
});

it('data must be an array', function () {
    \Pest\Laravel\postJson(
        'test-route',
        [
            'data' => 'string'
        ]
    )
        ->assertJsonApiValidationErrors('data');


    \Pest\Laravel\patchJson(
        'test-route',
        [
            'data' => 'string'
        ]
    )
        ->assertJsonApiValidationErrors('data');
});


it('data type is required', function () {
    \Pest\Laravel\postJson(
        'test-route',
        [
            'data' => [
                'attributes'
            ]
        ]
    )
        ->assertJsonApiValidationErrors('data.type');


    \Pest\Laravel\patchJson(
        'test-route',
        [
            'data' => [
                'attributes'
            ]
        ]
    )
        ->assertJsonApiValidationErrors('data.type');
});


it('data type must be a string', function () {
    \Pest\Laravel\postJson(
        'test-route',
        [
            'data' => [
                'type' => 1
            ]
        ]
    )
        ->assertJsonApiValidationErrors('data.type');


    \Pest\Laravel\patchJson(
        'test-route',
        [
            'data' => [
                'type' => 1
            ]
        ]
    )
        ->assertJsonApiValidationErrors('data.type');
});

it('data attributes is required', function () {
    \Pest\Laravel\postJson(
        'test-route',
        [
            'data' => [
                'type' => "string",
            ]
        ]
    )
        ->assertJsonApiValidationErrors('data.attributes');


    \Pest\Laravel\patchJson(
        'test-route',
        [
            'data' => [
                'type' => "string",
            ]
        ]
    )
        ->assertJsonApiValidationErrors('data.attributes');
});

it('data attributes must be an array', function () {
    \Pest\Laravel\postJson(
        'test-route',
        [
            'data' => [
                'type' => "string",
                'attributes' => "string",
            ]
        ]
    )
        ->assertJsonApiValidationErrors('data.attributes');


    \Pest\Laravel\patchJson(
        'test-route',
        [
            'data' => [
                'type' => "string",
                'attributes' => "string",
            ]
        ]
    )
        ->assertJsonApiValidationErrors('data.attributes');
});

it('data id is required', function () {

    \Pest\Laravel\patchJson(
        'test-route',
        [
            'data' => [
                'type' => "string",
                'attributes' => [
                    'title' => 'title'
                ]
            ]
        ]
    )
        ->assertJsonApiValidationErrors('data.id');
});

it('data id must be a string', function () {

    \Pest\Laravel\patchJson(
        'test-route',
        [
            'data' => [
                'id' => 1,
                'type' => "string",
                'attributes' => [
                    'title' => 'title'
                ]
            ]
        ]
    )
        ->assertJsonApiValidationErrors('data.id');
});
<?php

use App\Http\Middleware\ValidateJsonApiDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (){
    Route::any('test-route', fn()=> 'ok')
        ->middleware(ValidateJsonApiDocument::class);
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
        []
    )
        ->assertJsonApiValidationErrors('data');


    \Pest\Laravel\patchJson(
        'test-route',
        []
    )
        ->assertJsonApiValidationErrors('data');
});

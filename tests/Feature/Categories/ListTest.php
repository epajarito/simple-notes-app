<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can fetch single category', function () {

    $category = Category::factory()->create();

    $response = \Pest\Laravel\getJson(
        route('api.categories.show', $category)
    );

    $response->assertJsonApiResource($category, [
        'name' => $category->name
    ]);

});

it('can fetch all notes', function () {
    $categories = \App\Models\Category::factory()->count(3)->create();

    $response = \Pest\Laravel\getJson(route('api.categories.index'));

    $response->assertJsonApiResourceCollection(
        $categories,
        ['name']
    );
});

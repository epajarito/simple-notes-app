<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it("can create note", function (){

    $response = \Pest\Laravel\postJson(
        route('api.notes.store'),
        [
            'title' => $title = "mi titulo",
            'slug' => str($title)->slug()->toString(),
            'content' => "mi contenido",
            'favorite' => 1
        ]
    )
        ->assertCreated()
        ->assertStatus(201);

    $note = \App\Models\Note::first();

    $response->assertJsonApiResource(
        $note,
        [
            'title' => "mi titulo",
            'slug' => 'mi-titulo',
            'content' => 'mi contenido',
            'is_favorite' => (bool)$note->favorite,
            'created_at' => (string)$note->created_at
        ]
    );


});

it("can not create note title attribute is required", function (){
    \Pest\Laravel\postJson(
        route('api.notes.store'),
        [
            'slug' => 'mi-nota',
            'content' => "mi contenido",
            'favorite' => 1
        ]
    )->assertJsonApiValidationErrors('title');
});

it("can not create note slug attribute is required", function (){
    \Pest\Laravel\postJson(
        route('api.notes.store'),
        [
            'title' => "mi nota",
            'content' => "mi contenido",
            'favorite' => true
        ]
    )->assertJsonApiValidationErrors('slug');
});

it("can not create note content attribute is required", function (){
    \Pest\Laravel\postJson(
        route('api.notes.store'),
        [
            'title' => $title = "mi nota",
            'slug' => str($title)->slug()->toString() ,
            'favorite' => true
        ]
    )->assertJsonApiValidationErrors('content');
});


it('slug must be unique', function (){

    $firstNote = \App\Models\Note::factory()->create();
    $secondNote = \App\Models\Note::factory()->create();


    \Pest\Laravel\patchJson(
        route('api.notes.update', $firstNote),
        [
            'title' => "my title",
            'content' => "some content",
            'slug' => $secondNote->slug
        ]
    )
        ->assertJsonApiValidationErrors('slug');

});

it('slug only accepts letters numbers and alphanumeric string', function (){

    \Pest\Laravel\postJson(
        route('api.notes.store'),
        [
            'title' => "my title",
            'content' => "some content",
            'slug' => "%$&#$#"
        ]
    )
        ->assertJsonApiValidationErrors('slug');

});

it('slug must not contain underscores', function (){

    \Pest\Laravel\postJson(
        route('api.notes.store'),
        [
            'title' => "my title",
            'content' => "some content",
            'slug' => "with_undercores"
        ]
    )
        ->assertSee("El valor del campo data.attributes.slug no debe contener guiones bajo.")
        ->assertJsonApiValidationErrors('slug');

});

it('slug must not start with dashes', function (){

    \Pest\Laravel\postJson(
        route('api.notes.store'),
        [
            'title' => "my title",
            'content' => "some content",
            'slug' => "-starts-with-dashes"
        ]
    )
        ->assertSee("El valor del campo data.attributes.slug no debe comenzar con guiones.")
        ->assertJsonApiValidationErrors('slug');
});

it('slug must not ent with dashes', function (){

    \Pest\Laravel\postJson(
        route('api.notes.store'),
        [
            'title' => "my title",
            'content' => "some content",
            'slug' => "ends-with-dashes-"
        ]
    )
        ->assertSee("El valor del campo data.attributes.slug no debe terminar con guiones.")
        ->assertJsonApiValidationErrors('slug');
});


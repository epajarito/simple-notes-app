<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it("can create note", function (){

    $response = \Pest\Laravel\postJson(
        route('api.notes.store'),
        [
            'data' => [
                'attributes' => [
                    'title' => $title = "mi titulo",
                    'slug' => str($title)->slug()->toString(),
                    'content' => "mi contenido",
                    'favorite' => 1
                ]
            ]
        ]
    )
        ->assertCreated()
        ->assertStatus(201);

    $note = \App\Models\Note::first();

    $response->assertHeader(
        'Location',
        route('api.notes.show', $note)
    );

    $response->assertExactJson([
        'data' => [
            'type' => 'notes',
            'id' => (string)$note->id,
            'attributes' => [
                'title' => "mi titulo",
                'slug' => 'mi-titulo',
                'content' => 'mi contenido',
                'is_favorite' => (bool)$note->favorite,
                'created_at' => $note->created_at
            ],
            'links' => [
                'self' => route('api.notes.show', $note)
            ]
        ]
    ]);


});

it("can not create note title attribute is required", function (){
    $response = \Pest\Laravel\postJson(
        route('api.notes.store'),
        [
            'data' => [
                'attributes' => [
                    'slug' => 'mi-nota',
                    'content' => "mi contenido",
                    'favorite' => 1
                ]
            ]
        ]
    );


    $response->assertJsonApiValidationErrors('title');
});

it("can not create note slug attribute is required", function (){
    \Pest\Laravel\postJson(
        route('api.notes.store'),
        [
            'data' => [
                'attributes' => [
                    'title' => "mi nota",
                    'content' => "mi contenido",
                    'favorite' => true
                ]
            ]
        ]
    )->assertJsonApiValidationErrors('slug');
});

it("can not create note content attribute is required", function (){
    \Pest\Laravel\postJson(
        route('api.notes.store'),
        [
            'data' => [
                'attributes' => [
                    'title' => $title = "mi nota",
                    'slug' => str($title)->slug()->toString() ,
                    'favorite' => true
                ]
            ]
        ]
    )->assertJsonApiValidationErrors('content');
});



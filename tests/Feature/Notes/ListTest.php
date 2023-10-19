<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can fetch single note', function () {
    $note = \App\Models\Note::factory()->create();

    \Pest\Laravel\getJson(
        route('api.notes.show', $note)
    )
        ->assertOk()
        ->assertStatus(200)
        ->assertExactJson([
            'data' => [
                'id' => (string)$note->id,
                'type' => 'notes',
                'attributes' => [
                    'title' => $note->title,
                    'content' => $note->content,
                    'slug' => $note->slug,
                    'is_favorite' => (bool)$note->favorite,
                    'created_at' => (string)$note->created_at
                ],
                'links' => [
                    'self' => route('api.notes.show', $note)
                ]
            ]
        ]);
});

it('can fetch all notes', function () {
    $notes = \App\Models\Note::factory()->count(3)->create();

    $response = \Pest\Laravel\getJson(route('api.notes.index'));

    $response->assertJsonApiResourceCollection(
        $notes,
        ['title', 'content', 'slug', 'is_favorite', 'created_at']
    );
});
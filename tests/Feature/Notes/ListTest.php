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

    $response->assertJson([
        'data' => [
            [
                'id' => (string)$notes[0]->id,
                'type' => 'notes',
                'attributes' => [
                    'title' => $notes[0]->title,
                    'content' => $notes[0]->content,
                    'slug' => (string)$notes[0]->slug,
                    'is_favorite' => (bool)$notes[0]->favorite,
                    'created_at' => (string)$notes[0]->created_at
                ],
                'links' => [
                    'self' => route('api.notes.show', $notes[0])
                ]
            ],
            [
                'id' => (string)$notes[1]->id,
                'type' => 'notes',
                'attributes' => [
                    'title' => $notes[1]->title,
                    'content' => $notes[1]->content,
                    'slug' => (string)$notes[1]->slug,
                    'is_favorite' => (bool)$notes[1]->favorite,
                    'created_at' => (string)$notes[1]->created_at
                ],
                'links' => [
                    'self' => route('api.notes.show', $notes[1])
                ]
            ],
            [
                'id' => (string)$notes[2]->id,
                'type' => 'notes',
                'attributes' => [
                    'title' => $notes[2]->title,
                    'content' => $notes[2]->content,
                    'slug' => (string)$notes[2]->slug,
                    'is_favorite' => (bool)$notes[2]->favorite,
                    'created_at' => (string)$notes[2]->created_at
                ],
                'links' => [
                    'self' => route('api.notes.show', $notes[2])
                ]
            ]
        ]
    ]);
});
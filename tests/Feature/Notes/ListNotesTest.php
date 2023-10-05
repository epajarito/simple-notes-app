<?php

namespace Tests\Feature\Notes;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListNotesTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function can_fetch_a_single_note()
    {
        $this->withoutExceptionHandling();
        $note = Note::factory()->create();
        $response = $this->getJson(route('api.notes.show', $note));

        $response->assertExactJson([
            'data' => [
                'id' => (string)$note->id,
                'type' => 'notes',
                'attributes' => [
                    'title' => $note->title,
                    'content' => $note->content,
                    'slug' => $note->slug,
                    'is_favorite' => (bool)$note->favorite,
                    'created_at' => $note->created_at
                ],
                'links' => [
                    'self' => route('api.notes.show', $note)
                ]
            ]
        ]);
    }
    /** @test */
    public function can_fetch_all_notes()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $notes = Note::factory()->count(3)->create();
        $response = $this->getJson(route('api.notes.index'));

        $response->assertExactJson([
            'data' => [
                [
                    'type' => 'notes',
                    'id' => (string)$notes[0]->id,
                    'attributes' => [
                        'title' => $notes[0]->title,
                        'content' => $notes[0]->content,
                        'slug' => $notes[0]->slug,
                        'is_favorite' => (bool)$notes[0]->favorite,
                        'created_at' => $notes[0]->created_at
                    ],
                    'links' => [
                        'self' => route('api.notes.show', $notes[0])
                    ]
                ],
                [
                    'type' => 'notes',
                    'id' => (string)$notes[1]->id,
                    'attributes' => [
                        'title' => $notes[1]->title,
                        'content' => $notes[1]->content,
                        'slug' => $notes[1]->slug,
                        'is_favorite' => (bool)$notes[1]->favorite,
                        'created_at' => $notes[1]->created_at
                    ],
                    'links' => [
                        'self' => route('api.notes.show', $notes[1])
                    ]
                ],
                [
                    'type' => 'notes',
                    'id' => (string)$notes[2]->id,
                    'attributes' => [
                        'title' => $notes[2]->title,
                        'content' => $notes[2]->content,
                        'slug' => $notes[2]->slug,
                        'is_favorite' => (bool)$notes[2]->favorite,
                        'created_at' => $notes[2]->created_at
                    ],
                    'links' => [
                        'self' => route('api.notes.show', $notes[2])
                    ]
                ]
            ]
        ]);
    }
}

<?php

namespace Tests\Feature\Notes;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateNoteTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function can_create_note(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson(route('api.notes.store'), [
            'data' => [
                'type' => 'notes',
                'attributes' => [
                    'title' => "mi nota",
                    'slug' => 'mi-nota',
                    'content' => 'contenido'
                ]
            ]
        ]);

        $response->assertCreated();

        $note = Note::first();

        $response->assertHeader(
            'Location',
            route('api.notes.show', $note)
        );

        $response->assertExactJson([
            'data' => [
                'type' => 'notes',
                'id' => (string)$note->id,
                'attributes' => [
                    'title' => "mi nota",
                    'slug' => 'mi-nota',
                    'content' => 'contenido',
                    'is_favorite' => (bool)$note->favorite,
                    'created_at' => $note->created_at
                ],
                'links' => [
                    'self' => route('api.notes.show', $note)
                ]
            ]
        ]);
    }
}

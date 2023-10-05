<?php

it('can update post', function (){
    $note = \App\Models\Note::factory()->create();

    $response = \Pest\Laravel\putJson(
        route('api.notes.update', $note),
        [
            'title' => "title updated",
            'content' => "content updated"
        ]
    )
        ->assertOk()
        ->assertStatus(200);

    $response->assertExactJson(
        [
            'data' => [
                'type' => 'notes',
                'id' => (string)$note->id,
                'attributes' => [
                    'title' => "title updated",
                    'content' => "content updated",
                    'is_favorite' => (bool)$note->favorite,
                    'created_at' => $note->created_at,
                    'slug' => $note->slug
                ],
                'links' => [
                    'self' => route('api.notes.show', $note)
                ]
            ]
        ]
    );
});


it("can not update note title is required", function (){

    $note = \App\Models\Note::factory()->create();

    \Pest\Laravel\putJson(
            route('api.notes.update', $note),
            []
        )
        ->assertStatus(422)
        ->assertExactJson([
            'message' => "The title field is required. (and 1 more error)",
            "errors" => [
                "title" => [
                    "The title field is required."
                ],
                "content" => [
                    "The content field is required."
                ]
            ]
        ]);
});
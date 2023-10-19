<?php

it('can update post', function (){
    $note = \App\Models\Note::factory()->create();

    $response = \Pest\Laravel\patchJson(
        route('api.notes.update', $note),
        [
            'title' => "title updated",
            'slug' => $note->slug,
            'content' => "content updated"
        ]
    )
        ->assertOk();

    $response->assertJsonApiResource($note,
        [
            'title' => "title updated",
            'content' => "content updated",
            'is_favorite' => (bool)$note->favorite,
            'created_at' => (string)$note->created_at,
            'slug' => $note->slug
        ]
    );
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

    $note = \App\Models\Note::factory()->create();
    \Pest\Laravel\patchJson(
        route('api.notes.update', $note),
        [
            'title' => "my title",
            'content' => "some content",
            'slug' => "%$&#$#"
        ]
    )
        ->assertJsonApiValidationErrors('slug');

});

it('slug must not contain underscores', function (){

    $note = \App\Models\Note::factory()->create();
    \Pest\Laravel\patchJson(
        route('api.notes.update', $note),
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

    $note = \App\Models\Note::factory()->create();
    \Pest\Laravel\patchJson(
        route('api.notes.update', $note),
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

    $note = \App\Models\Note::factory()->create();
    \Pest\Laravel\patchJson(
        route('api.notes.update', $note),
        [
            'title' => "my title",
            'content' => "some content",
            'slug' => "ends-with-dashes-"
        ]
    )
        ->assertSee("El valor del campo data.attributes.slug no debe terminar con guiones.")
        ->assertJsonApiValidationErrors('slug');
});


it("can not update note title is required", function (){

    $note = \App\Models\Note::factory()->create();

    \Pest\Laravel\putJson(
            route('api.notes.update', $note),
            [
                'slug' => 'some-slug',
                'content' => 'some content'
            ]
        )
        ->assertStatus(422)
        ->assertJsonApiValidationErrors('title');
});

it("can not update note slug must be unique", function (){

    $firstNote = \App\Models\Note::factory()->create();
    $secondNote = \App\Models\Note::factory()->create();

    \Pest\Laravel\putJson(
        route('api.notes.update', $firstNote),
        [
            'slug' => $secondNote->slug,
            'title' => 'title',
            'content' => 'some content'
        ]
    )
        ->assertStatus(422)
        ->assertJsonApiValidationErrors('slug');
});

it("can not update note content is required", function (){

    $note = \App\Models\Note::factory()->create();

    \Pest\Laravel\putJson(
        route('api.notes.update', $note),
        [
            'title' => 'title',
            'slug' => 'some-slug'
        ]
    )
        ->assertStatus(422)
        ->assertJsonApiValidationErrors('content');
});
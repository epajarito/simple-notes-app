<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('specific fields can be requested in the index', function () {
    $note = \App\Models\Note::factory()->create();

    $url = route('api.notes.index',[
         'fields' => [
             'notes' => 'title,slug'
         ]
    ]);

    \Pest\Laravel\getJson($url)
        ->assertJsonFragment([
            'title' => $note->title,
            'slug' => $note->slug
        ])
        ->assertJsonMissing([
            'content' => $note->content
        ])
        ->assertJsonMissing([
            'content' => null
        ]);
});

it("route key must be added automatically in the index", function (){
    $note = \App\Models\Note::factory()->create();

    $url = route('api.notes.index',[
        'fields' => [
            'notes' => 'title'
        ]
    ]);

    \Pest\Laravel\getJson($url)
        ->assertJsonFragment([
            'title' => $note->title
        ])->assertJsonMissing([
            'slug' => $note->slug,
            'content' => $note->content
        ]);
});

it('specific fields can be requested in the show', function () {
    $note = \App\Models\Note::factory()->create();

    $url = route('api.notes.show',
        [
            'note' => $note,
            'fields' => [
                'notes' => 'title,slug'
        ]
    ]);

    \Pest\Laravel\getJson($url)
        ->assertJsonFragment([
            'title' => $note->title,
            'slug' => $note->slug
        ])
        ->assertJsonMissing([
            'content' => $note->content
        ])
        ->assertJsonMissing([
            'content' => null
        ]);
});

it("route key must be added automatically in the show", function (){
    $note = \App\Models\Note::factory()->create();

    $url = route('api.notes.show',[
        'note' => $note,
        'fields' => [
            'notes' => 'title'
        ]
    ]);

    \Pest\Laravel\getJson($url)
        ->assertJsonFragment([
            'title' => $note->title
        ])->assertJsonMissing([
            'slug' => $note->slug,
            'content' => $note->content
        ]);
});
<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can sort notes by title', function () {
    \App\Models\Note::factory()->create(['title' => 'C title']);
    \App\Models\Note::factory()->create(['title' => 'A title']);
    \App\Models\Note::factory()->create(['title' => 'B title']);

    $url = route('api.notes.index', ['sort' => 'title']);

    \Pest\Laravel\getJson($url)
        ->assertSeeInOrder([
           'A title',
           'B title',
           'C title',
        ]);
});

it('can sort notes by content', function () {
    \App\Models\Note::factory()->create(['content' => 'C content']);
    \App\Models\Note::factory()->create(['content' => 'A content']);
    \App\Models\Note::factory()->create(['content' => 'B content']);

    $url = route('api.notes.index', ['sort' => 'content']);

    \Pest\Laravel\getJson($url)
        ->assertSeeInOrder([
            'A content',
            'B content',
            'C content',
        ]);
});

it('can sort notes by title desc', function () {
    \App\Models\Note::factory()->create(['title' => 'C title']);
    \App\Models\Note::factory()->create(['title' => 'A title']);
    \App\Models\Note::factory()->create(['title' => 'B title']);

    $url = route('api.notes.index', ['sort' => '-title']);

    \Pest\Laravel\getJson($url)
        ->assertSeeInOrder([
            'C title',
            'B title',
            'A title',
        ]);
});

it('can sort notes by content desc', function () {
    \App\Models\Note::factory()->create(['content' => 'C content']);
    \App\Models\Note::factory()->create(['content' => 'A content']);
    \App\Models\Note::factory()->create(['content' => 'B content']);

    $url = route('api.notes.index', ['sort' => '-content']);

    \Pest\Laravel\getJson($url)
        ->assertSeeInOrder([
            'C content',
            'B content',
            'A content',
        ]);
});

it('can sort notes by title and content', function () {
    \App\Models\Note::factory()->create(['content' => 'A content', 'title' => 'A title']);
    \App\Models\Note::factory()->create(['content' => 'B content', 'title' => 'B title']);
    \App\Models\Note::factory()->create(['content' => 'C content', 'title' => 'A title']);

    $url = route('api.notes.index', ['sort' => 'title,-content']);

    \Pest\Laravel\getJson($url)
        ->assertSeeInOrder([
            'C content',
            'A content',
            'B content',
        ]);
});

it('can not sort notes by unknown field', function () {
    \App\Models\Note::factory()->count(3)->create();

    $url = route('api.notes.index', ['sort' => 'unknown']);

    \Pest\Laravel\getJson($url)
        ->assertStatus(400);
});
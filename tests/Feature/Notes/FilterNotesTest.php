<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can filter notes by title', function () {
    \App\Models\Note::factory()->create([
        'title' => "Mi first note"
    ]);

    \App\Models\Note::factory()->create([
        'title' => "Mi second note"
    ]);

    $url = route('api.notes.index',[
        'filter' => [
            'title' => 'first'
        ]
    ]);

    $response = \Pest\Laravel\getJson($url);

    $response->assertJsonCount(1, 'data');
    $response->assertSee("Mi first note")
        ->assertDontSee("Mi second note");
});

it('can filter notes by content', function () {
    \App\Models\Note::factory()->create([
        'content' => "Mi first note"
    ]);

    \App\Models\Note::factory()->create([
        'content' => "Mi second note"
    ]);

    $url = route('api.notes.index',[
        'filter' => [
            'content' => 'first'
        ]
    ]);

    $response = \Pest\Laravel\getJson($url);

    $response->assertJsonCount(1, 'data');
    $response->assertSee("Mi first note")
        ->assertDontSee("Mi second note");
});

it('can filter notes by year', function () {
    \App\Models\Note::factory()->create([
        'title' => "Mi first note",
        'created_at' => now()->year(1992)
    ]);

    \App\Models\Note::factory()->create([
        'title' => "Mi second note",
        'created_at' => now()->year(2002)
    ]);

    $url = route('api.notes.index',[
        'filter' => [
            'year' => '2002'
        ]
    ]);

    $response = \Pest\Laravel\getJson($url);

    $response->assertJsonCount(1, 'data');
    $response->assertSee("Mi second note")
        ->assertDontSee("Mi first note");
});

it('can filter notes by month', function () {
    \App\Models\Note::factory()->create([
        'title' => "Mi first note",
        'created_at' => now()->month(10)
    ]);

    \App\Models\Note::factory()->create([
        'title' => "Mi second note",
        'created_at' => now()->month(2)
    ]);

    $url = route('api.notes.index',[
        'filter' => [
            'month' => '10'
        ]
    ]);

    $response = \Pest\Laravel\getJson($url);

    $response->assertJsonCount(1, 'data');
    $response->assertSee("Mi first note")
        ->assertDontSee("Mi second note");
});

it('cannot filter notes by unknown field', function () {
    \App\Models\Note::factory()->create();

    $url = route('api.notes.index',[
        'filter' => [
            'unknown' => 'some data'
        ]
    ]);

    \Pest\Laravel\getJson($url)
        ->assertStatus(400);
});
<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can paginate notes', function () {
    $notes = \App\Models\Note::factory()->count(6)->create();

    $url = route('api.notes.index',[
        'page' => [
            'size' => 2,
            'number' => 2
        ]
    ]);

    $response = \Pest\Laravel\getJson($url);
    $response->assertSee([
        $notes[2]->title,
        $notes[3]->title,
    ]);

    $response->assertDontSee([
        $notes[0]->title,
        $notes[1]->title,
        $notes[4]->title,
        $notes[5]->title,
    ]);

    $response->assertJsonStructure([
        'links' => ['first', 'last', 'prev', 'next']
    ]);

    $firstLink = urldecode($response->json('links.first'));
    $lastLink = urldecode($response->json('links.last'));
    $prevLink = urldecode($response->json('links.prev'));
    $nextLink = urldecode($response->json('links.next'));

    \PHPUnit\Framework\assertStringContainsString('page[size]=2', $firstLink);
    \PHPUnit\Framework\assertStringContainsString('page[number]=1', $firstLink);

    \PHPUnit\Framework\assertStringContainsString('page[size]=2', $lastLink);
    \PHPUnit\Framework\assertStringContainsString('page[number]=3', $lastLink);

    \PHPUnit\Framework\assertStringContainsString('page[size]=2', $prevLink);
    \PHPUnit\Framework\assertStringContainsString('page[number]=1', $prevLink);

    \PHPUnit\Framework\assertStringContainsString('page[size]=2', $nextLink);
    \PHPUnit\Framework\assertStringContainsString('page[number]=3', $nextLink);
});

it('can sort and paginate notes', function () {
    \App\Models\Note::factory()->create(['title' => 'C title']);
    \App\Models\Note::factory()->create(['title' => 'A title']);
    \App\Models\Note::factory()->create(['title' => 'B title']);

    $url = route('api.notes.index',[
        'sort' => 'title',
        'page' => [
            'size' => 1,
            'number' => 2
        ]
    ]);
    $response = \Pest\Laravel\getJson($url);
    $response->assertSee([
        "B title",
    ]);

    $response->assertDontSee([
        "A title",
        "C title",
    ]);

    $firstLink = urldecode($response->json('links.first'));
    $lastLink = urldecode($response->json('links.last'));
    $prevLink = urldecode($response->json('links.prev'));
    $nextLink = urldecode($response->json('links.next'));

    \PHPUnit\Framework\assertStringContainsString('sort=title', $firstLink);
    \PHPUnit\Framework\assertStringContainsString('sort=title', $lastLink);
    \PHPUnit\Framework\assertStringContainsString('sort=title', $prevLink);
    \PHPUnit\Framework\assertStringContainsString('sort=title', $nextLink);
});

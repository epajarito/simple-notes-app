<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can include related category of an note', function () {
    $note = \App\Models\Note::factory()->create();

    $url = route('api.notes.show', [
        'note' => $note,
        'include' => 'category'
    ]);

    $response = $this->getJson($url);

    $response->assertJson([
         'included' => [
             [
                 'type' => 'categories',
                 'id' => $note->category->getRouteKey(),
                 'attributes' => [
                     'name' => $note->category->name
                 ]
             ]
         ]
    ]);
});

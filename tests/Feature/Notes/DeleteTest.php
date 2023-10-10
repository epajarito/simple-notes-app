<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can destroy single note', function () {
    $note = \App\Models\Note::factory()->create();

    \Pest\Laravel\deleteJson(
        route('api.notes.destroy', $note)
    )->assertNoContent();
});

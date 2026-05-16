<?php

use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

test('it belongs to a user', function () {
    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(User::class);

});

test('it can have steps', function () {
    $idea = Idea::factory()->create();

    // expect($idea->steps)->toBeInstanceOf(Collection::class);
    expect($idea->steps)->toBeEmpty();

    $idea->steps()->create([
        'description' => 'Do the thing',
    ]);

    expect($idea->fresh()->steps)->toHaveCount(1);

});

test('it can format a description using markdown', function () {
    $idea = new Idea([
        'description' => 'Hello **world**',
    ]);

    // dd($idea->formattedDescription);

    expect($idea->formattedDescription)->toEqual("<p>Hello <strong>world</strong></p>\n");
});

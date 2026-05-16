<?php

use App\Models\Idea;
use App\Models\User;
use Tests\TestCase;

it('create a new idea', function () {
    $user = User::factory()->create();
    /** @var TestCase $this */
    $this->actingAs($user);

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'Some example title')
        ->click('@button-status-completed')
        ->fill('description', 'An example description')
        ->fill('@new-link', 'https://laracast.com')
        ->click('@new-link-button')
        ->fill('@new-link', 'https://dir.bg')
        ->click('@new-link-button')
        ->fill('@new-step', 'Do a thing')
        ->click('@new-step-button')
        ->fill('@new-step', 'Do another thing')
        ->click('@new-step-button')
        ->click('Create')
        ->assertPathIs('/ideas');
    // ->debug()

    // expect(Idea::count())->toBe(1);

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some example title',
        'status' => 'completed',
        'description' => 'An example description',
        'links' => ['https://laracast.com', 'https://dir.bg'],
    ]);

    expect($idea->steps)->toHaveCount(2);
});

it('edits an existing idea', function () {
    $user = User::factory()->create();
    /** @var TestCase $this */
    $this->actingAs($user);

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'Some example title')
        ->click('@button-status-completed')
        ->fill('description', 'An example description')
        ->fill('@new-link', 'https://laracast.com')
        ->click('@new-link-button')
        ->fill('@new-step', 'Do a thing')
        ->click('@new-step-button')
        ->click('Update')
        ->assertRoute('idea.show', [$idea]);
    // ->debug();

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some example title',
        'status' => 'completed',
        'description' => 'An example description',
        'links' => [$idea->links[0], 'https://laracast.com'],
    ]);

    expect($idea->steps)->toHaveCount(1);
});

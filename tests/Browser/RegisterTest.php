<?php

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

it('registers a user', function () {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email', 'john@mail.com')
        ->fill('password', 'password123')
        ->click('@register-button')
        ->assertRoute('idea.index');

    /** @var TestCase $this */
    $this->assertAuthenticated();

    expect(Auth::user())->toMatchArray([
        'name' => 'John Doe',
        'email' => 'john@mail.com',
    ]);
});

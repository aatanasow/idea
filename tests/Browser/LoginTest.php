<?php

use App\Models\User;

it('logs in a user', function () {

    $user = User::factory()->create(['password' => 'password123']);

    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'password123')
        // ->click('[data-test:login-button]')
        ->click('@login-button')
        ->assertPathIs('/');

    /** @var Tests\TestCase $this */
    $this->assertAuthenticated();

});

it('logs out a user', function () {

    $user = User::factory()->create();

    /** @var Tests\TestCase $this */
    $this->actingAs($user);

    visit('/')
        ->click('Log Out');

    $this->assertGuest();

});

<?php

use App\Models\User;
use App\Notifications\EmailChanged;
use Illuminate\Support\Facades\Notification;

it('requires authentication', function () {
    // visit(route('profile.edit'))->assertPathIs('/login');
    $this->get(route('profile.edit'))->assertRedirect('/login');
});

it('edits a profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit(route('profile.edit'))
        ->assertValue('name', $user->name)
        ->fill('name', 'New Name')
        ->assertValue('email', $user->email)
        ->fill('email', 'new@mail.com')
        ->click('Update account')
        ->assertSee('Profile updated!');

    expect($user->fresh())->toMatchArray([
        'name' => 'New Name',
        'email' => 'new@mail.com',
    ]);
});

it('notifies the original email if updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Notification::fake();

    $originalEmail = $user->email;

    visit(route('profile.edit'))
        ->assertValue('name', $user->name)
        ->fill('email', 'new@mail.com')
        ->click('Update account')
        ->assertSee('Profile updated!');

    Notification::assertSentOnDemand(EmailChanged::class, fn (EmailChanged $notification, $routs, $notifiable) => $notifiable->routes['mail'] === $originalEmail);

});

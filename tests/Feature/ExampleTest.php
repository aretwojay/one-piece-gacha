<?php

use App\Models\User;

test('guest is redirected from home to login', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('login'));
});

test('authenticated user is redirected from home to dashboard', function () {
    $user = new User([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response = $this->actingAs($user)->get('/');

    $response->assertRedirect(route('dashboard'));
});

test('guest can view login and register pages', function () {
    $this->get(route('login'))->assertSuccessful();

    $this->get(route('register'))->assertSuccessful();
});

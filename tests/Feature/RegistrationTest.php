<?php

use App\Providers\RouteServiceProvider;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    if (Role::where('name', 'Super Admin')->doesntExist()) {
        Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
    }
    if (Role::where('name', 'Admin')->doesntExist()) {
        Role::create(['name' => 'Admin', 'guard_name' => 'web']);
    }
    if (Role::where('name', 'Customer')->doesntExist()) {
        Role::create(['name' => 'Customer', 'guard_name' => 'web']);
    }
});

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
})->skip(function () {
    return ! Features::enabled(Features::registration());
}, 'Registration support is not enabled.');

test('registration screen cannot be rendered if support is disabled', function () {
    $response = $this->get('/register');

    $response->assertStatus(404);
})->skip(function () {
    return Features::enabled(Features::registration());
}, 'Registration support is enabled.');

test('new users can register', function () {
    $response = $this->post('/register', [
        'first_name' => 'Normal',
        'last_name' => 'One',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

    $this->assertAuthenticated();

    $response->assertRedirect(RouteServiceProvider::HOME);
})->skip(function () {
    return ! Features::enabled(Features::registration());
}, 'Registration support is not enabled.');

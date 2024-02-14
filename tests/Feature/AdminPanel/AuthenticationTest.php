<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Filament\Pages\Auth\Login;
use Livewire\Livewire;
use Filament\Facades\Filament;
use Illuminate\Support\Str;

test('login screen can be rendered', function () {
    $response = $this->get('/admin/login');

    $response->assertStatus(200);
});

it('can authenticate using the login screen', function () {
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    $user = User::factory()->create();
    if (Role::where('name', config('filament-shield.panel_user.name'))->doesntExist()) {
        Role::create([
            'name' => config('filament-shield.panel_user.name'),
            'guard_name' => 'web',
        ]);
    }
    $user->assignRole(config('filament-shield.panel_user.name'));

    Livewire::test(Login::class)
        ->fillForm([
            'email' => $user->email,
            'password' => 'password',
        ])
        ->call('authenticate')
        ->assertRedirect(Filament::getUrl());
});


it('cannot authenticate with incorrect credentials', function () {
    $userToAuthenticate = User::factory()->create();

    Livewire::test(Login::class)
        ->fillForm([
            'email' => $userToAuthenticate->email,
            'password' => 'incorrect-password',
        ])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);

    $this->assertGuest();
});

it('can authenticate and redirect user to their intended URL', function () {
    session()->put('url.intended', $intendedUrl = Str::random());

    $userToAuthenticate = User::factory()->create();

    Livewire::test(Login::class)
        ->fillForm([
            'email' => $userToAuthenticate->email,
            'password' => 'password',
        ])
        ->call('authenticate')
        ->assertRedirect($intendedUrl);
});

it('can redirect unauthenticated app requests', function () {
    $this->get(route('filament.admin.pages.dashboard'))->assertRedirect(Filament::getLoginUrl());
});

/*
it('cannot authenticate on unauthorized panel', function () {
    $userToAuthenticate = User::factory()->create();

    Filament::setCurrentPanel(Filament::getPanel('custom'));

    Livewire::test(Login::class)
        ->fillForm([
            'email' => $userToAuthenticate->email,
            'password' => 'password',
        ])
        ->call('authenticate')
        ->assertHasFormErrors(['email']);

    $this->assertGuest();
});
*/
it('can throttle authentication attempts', function () {
    $this->assertGuest();

    $userToAuthenticate = User::factory()->create();

    foreach (range(1, 5) as $i) {
        Livewire::test(Login::class)
            ->fillForm([
                'email' => $userToAuthenticate->email,
                'password' => 'password',
            ])
            ->call('authenticate');

        $this->assertAuthenticated();

        auth()->logout();
    }

    Livewire::test(Login::class)
        ->fillForm([
            'email' => $userToAuthenticate->email,
            'password' => 'password',
        ])
        ->call('authenticate')
        ->assertNotified();

    $this->assertGuest();
});

it('can validate `email` is required', function () {
    Livewire::test(Login::class)
        ->fillForm(['email' => ''])
        ->call('authenticate')
        ->assertHasFormErrors(['email' => ['required']]);
});

it('can validate `email` is valid email', function () {
    Livewire::test(Login::class)
        ->fillForm(['email' => 'invalid-email'])
        ->call('authenticate')
        ->assertHasFormErrors(['email' => ['email']]);
});

it('can validate `password` is required', function () {
    Livewire::test(Login::class)
        ->fillForm(['password' => ''])
        ->call('authenticate')
        ->assertHasFormErrors(['password' => ['required']]);
});

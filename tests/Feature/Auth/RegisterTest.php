<?php

use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

test('Render Register successfully', function () {
    livewire::test(Register::class)
        ->assertStatus(200);
});



test('Successfully register an account', function () {
    // Ensure user starts as unauthenticated
    $this->assertFalse(Auth::check());

    Livewire::test(Register::class)
        ->set('name', 'Test')
        ->set('email', 'test@mail.com')
        ->set('password', 'admin')
        ->set('password_confirmation', 'admin')
    ->call('register')
    ->assertSuccessful();

    $this->assertDatabaseHas('users', [
        'email' => 'test@mail.com',
        'is_active' => false
    ]);

    $this->assertDatabaseHas('staff', [
        'name' => 'Test',
        'email' => 'test@mail.com',
    ]);

    // Ensure the user is still unauthenticated
    $this->assertFalse(Auth::check());
});


use App\Models\User;

test('Validation errors for all fields including unique email', function () {
    // Create a preexisting user
    User::factory()->create([
        'email' => 'existing@mail.com',
    ]);

    $cases = [
        ['data' => ['email' => 'test@mail.com', 'password' => 'admin'], 'errors' => ['name' => 'required']],
        ['data' => ['name' => 'Test', 'password' => 'admin'], 'errors' => ['email' => 'required']],
        ['data' => ['name' => 'Test', 'email' => 'invalid-email', 'password' => 'admin'], 'errors' => ['email' => 'email']],
        ['data' => ['name' => 'Test', 'email' => 'existing@mail.com', 'password' => 'admin'], 'errors' => ['email' => 'unique']],
        ['data' => ['name' => 'Test', 'email' => 'test@mail.com'], 'errors' => ['password' => 'required']],
        ['data' => ['name' => 'Test', 'email' => 'test@mail.com', 'password' => 'admin', 'password_confirmation' => 'not-matching'], 'errors' => ['password' => 'confirmed']],
    ];

    foreach ($cases as $case) {
        Livewire::test(Register::class)
            ->set('name', $case['data']['name'] ?? null)
            ->set('email', $case['data']['email'] ?? null)
            ->set('password', $case['data']['password'] ?? null)
            ->set('password_confirmation', $case['data']['password_confirmation'] ?? null)
            ->call('register')
            ->assertHasErrors($case['errors']);
    }
});


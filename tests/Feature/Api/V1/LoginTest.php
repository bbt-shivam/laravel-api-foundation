<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

it('can login with valid credentials', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password')
    ]);

    $response = postJson(apiV1('/login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);
    
    assertApiSuccess($response);
});

it('fails with invalid credentials', function(){
    $user = User::factory()->create();

    $response = postJson(apiV1('/login'), [
        'email' => $user->email,
        'password' => 'wrong-password'
    ]);
    
    assertApiError(
        response: $response,
        status: 422
    );
});
<?php

use App\Models\User;

test('a user can login', function () {
    //  GIVEN
    $user = User::factory()->create();

    //  WHEN
    $response = $this->post('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    //  THEN
    $response->assertStatus(200);
    $response->assertJsonStructure(['message', 'user', 'token']);
});


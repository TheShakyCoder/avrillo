<?php

use App\Models\User;

test('a user can register', function () {
    //  GIVEN
    $user = User::factory()->raw();

    //  WHEN
    $response = $this->post('/api/register', $user);

    //  THEN
    $response->assertStatus(201);
    $response->assertJsonStructure(['token']);
});

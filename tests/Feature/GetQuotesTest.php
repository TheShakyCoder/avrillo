<?php

test('i can get 5 quotes', function () {
    //  GIVEN
    $count = 5;

    //  WHEN
    $response = $this->get('/api/quotes', [
        'Token' => config('auth.api.token')
    ]);

    //  THEN
    $response->assertStatus(200);
    $response->assertJsonCount($count);
});

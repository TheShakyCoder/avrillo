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
    $response->assertJsonCount($count, 'data');
});

test('i can get 5 more quotes', function () {
    //  GIVEN
    $count = 5;

    //  WHEN
    $response = $this->get('/api/quotes', [
        'Token' => config('auth.api.token')
    ]);
    $response->assertStatus(200);

    if($response->json('to') == $response->json('total')) {
        return;
    }

    $response2 = $this->get('/api/quotes?page=2', [
        'Token' => config('auth.api.token')
    ]);

    //  THEN
    $response2->assertStatus(200);
    $response2->assertJson(['current_page' => 2]);
});

test('i cannot get 5 quotes', function () {
    //  GIVEN
    $count = 5;

    //  WHEN
    $response = $this->get('/api/quotes', [
        'Token' => 'scammer'
    ]);

    //  THEN
    $response->assertStatus(401);
});

<?php

use App\Models\User;
use Illuminate\Support\Str;

test('i can get 5 quotes', function () {
    //  GIVEN
    $count = 5;
    $user = User::factory()->create();
    $token = $user->createToken(Str::random(10));
    $plainTextToken = $token->plainTextToken;

    //  WHEN
    $response = $this->get('/api/quotes', [
        'Authorization' => 'Bearer '.$plainTextToken
    ]);

    //  THEN
    $response->assertStatus(200);
    $response->assertJsonCount($count, 'data');
});

test('i can get 5 more quotes', function () {
    //  GIVEN
    $user = User::factory()->create();
    $token = $user->createToken(Str::random(10));
    $plainTextToken = $token->plainTextToken;

    //  WHEN
    $response = $this->get('/api/quotes', [
        'Authorization' => 'Bearer '.$plainTextToken
    ]);
    $response->assertStatus(200);

    if($response->json('to') == $response->json('total')) {
        return;
    }

    $response2 = $this->get('/api/quotes?page=2', [
        'Authorization' => 'Bearer '.$plainTextToken
    ]);

    //  THEN
    $response2->assertStatus(200);
    $response2->assertJson(['current_page' => 2]);
});

test('i cannot get 5 quotes', function () {
    //  GIVEN

    //  WHEN
    $response = $this->get('/api/quotes', [
        'Authorization' => 'Bearer scammer',
        'Accept' => 'application/json'
    ]);

    //  THEN
    $response->assertStatus(401);
});

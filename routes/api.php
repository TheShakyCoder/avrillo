<?php

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('token')->get('/quotes', function (Request $request) {
    $query = Quote::query()->limit(5)->inRandomOrder();
    $count = $query->count();
    while($count < 5) {
        //  get more quotes
        $http = \Illuminate\Support\Facades\Http::get('https://api.kanye.rest');
        Quote::query()->updateOrCreate($http->json(), []);

        $query = Quote::query()->limit(5)->inRandomOrder();
        $count = $query->count();
    }
    return $query->get();
});

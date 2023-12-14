<?php

use App\Http\Controllers\QuoteController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required'],
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    try {
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);
    } catch(Exception $e) {
        return response()->json([
            'message' => 'there was a problem with your registration details'
        ], 401);
    }

    return response()->json([
        'message' => 'Success!'
    ], 201);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('token')->get('/quotes', [QuoteController::class, 'index']);

<?php

use App\Http\Controllers\QuoteController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
            'message' => $e->getMessage()
        ], 401);
    }

    $token = $user->createToken(Str::random(10));

    return response()->json([
        'message' => 'Success!',
        'token' => $token->plainTextToken
    ], 201);
})->name('register');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'there was a problem with your email and/or password'
        ], 403);
    }

    $token = $request->user()->createToken(Str::random(10));

    return response()->json([
        'message' => 'Success!',
        'user' => $request->user(),
        'token' => $token->plainTextToken
    ]);
})->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/quotes', [QuoteController::class, 'index']);

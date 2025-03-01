<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', function (Request $request) {
    // Validate the request
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Define the unique rate limit key based on the user’s email
    $key = 'login-attempts:'.$request->email;

    // Check if too many login attempts
    if (RateLimiter::tooManyAttempts($key, $maxAttempts = 3)) {
        $seconds = RateLimiter::availableIn($key);
        return response()->json([
            'message' => 'Too many login attempts. Please try again in '.$seconds.' seconds.'
        ], 429);
    }

    // Find the user by email
    $user = User::where('email', $request->email)->first();

    // Check if the user exists and the password is correct
    if (!$user || !Hash::check($request->password, $user->password)) {
        // Increment the number of login attempts for this user
        RateLimiter::hit($key, $decaySeconds = 300); // Decay time is 5 minutes

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Clear the rate limiter on successful login
    RateLimiter::clear($key);

    // Create a token for the user
    $token = $user->createToken('auth_token')->plainTextToken;

    // Return the token in the response
    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
    ], 200);
});

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
});

Route::prefix('v1')->group(base_path('routes/api_v1/api_v1.php'));
Route::prefix('v2')->group(base_path('routes/api_v2/api_v2.php'));
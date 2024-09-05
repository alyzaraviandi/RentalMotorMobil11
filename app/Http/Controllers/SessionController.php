<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{
    // Display login form (for web routes, not used in API)
    public function createCustomer()
    {
        return view('auth.loginCustomer');
    }

    public function createAdmin()
    {
        return view('auth.loginAdmin');
    }

    public function storeCustomer(Request $request)
    {
        // Validate the request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if the authenticated user is a customer
            if ($user->role === 'customer') {
                // For API requests, return a token
                if ($request->expectsJson()) {
                    // Generate a new token
                    $token = $user->createToken('YourAppName')->plainTextToken;

                    return response()->json([
                        'message' => 'Login successful!',
                        'user' => $user,
                        'token' => $token
                    ], 200);
                }
                // For web requests, redirect to dashboard
                return redirect()->route('dashboardCustomer');
            } else {
                // Logout and invalidate session for non-customer roles

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Redirect to the login page (loginCustomer.create)
                return redirect()->route('loginCustomer.create')->with('error', 'You are not authorized to access this page.');
            }
        }

        return redirect()->route('loginCustomer.create')->with('error', 'Credentials do not match our records');
    }

    public function storeAdmin(Request $request)
    {
        // Validate the request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if the authenticated user is a customer
            if ($user->role === 'admin') {
                // For API requests, return a token
                if ($request->expectsJson()) {
                    // Generate a new token
                    $token = $user->createToken('YourAppName')->plainTextToken;

                    return response()->json([
                        'message' => 'Login successful!',
                        'user' => $user,
                        'token' => $token
                    ], 200);
                }
                // For web requests, redirect to dashboard
                return redirect()->route('dashboardAdmin');
            } else {
                // Logout and invalidate session for non-customer roles

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Redirect to the login page (loginCustomer.create)
                return redirect()->route('loginAdmin.create')->with('error', 'You are not authorized to access this page.');
            }
        }

        return redirect()->route('loginAdmin.create')->with('error', 'Credentials do not match our records');
    }


    // Handle logout request
    public function destroy(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            // Revoke all tokens for the user
            $user->tokens()->delete();

            // Log out the user
            Auth::logout();

            // Invalidate the session
            $request->session()->invalidate();

            // Regenerate the CSRF token
            $request->session()->regenerateToken();

            // Redirect to the login page (loginCustomer.create)
            return redirect()->route('loginCustomer.create')->with('message', 'Logged out successfully.');
        }
        return redirect()->route('loginCustomer.create')->with('info', 'No active session found. Redirected to login.');
    }
}

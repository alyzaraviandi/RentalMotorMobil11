<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log; // Import the Log facade

class RegisterController extends Controller
{
    public function createCustomer()
    {
        return view('auth.registerCustomer');
    }

    public function createAdmin()
    {
        return view('auth.registerAdmin');
    }

    public function storeCustomer(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the user with the role 'customer'
        $user = User::create([
            'name' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'customer', // Set the role to 'customer'
        ]);

        return redirect()->action([SessionController::class, 'createCustomer']);
    }

    public function storeAdmin(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the user with the role 'customer'
        $user = User::create([
            'name' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'admin', // Set the role to 'customer'
        ]);

        return redirect()->action([SessionController::class, 'createAdmin']);
    }
}

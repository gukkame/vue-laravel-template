<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new user instance
        $user = new User();
        $user->name = $validatedData['name'];

        // Save the user to the database
        $user->save();

        // Return a response
        return response()->json(['message' => 'User added successfully', 'user' => $user], 201);
    }
    public function index()
    {
        // Get all users from the database
        $users = User::all();

        // Return a response
        return response()->json($users, 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getAllUsers()
    {
        Log::info('Received request to get all users');
        
        $users = User::all();
        Log::info('Users: ' . $users->toJson());
        return response()->json($users);
    }

    public function addNewUser(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'User added successfully']);
    }

    public function deleteUser(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function editUser(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            return response()->json(['message' => 'User updated successfully']);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function searchUser(Request $request)
    {
        $users = User::where('name', 'like', '%' . $request->name . '%')->get();
        return response()->json($users);
    }
}
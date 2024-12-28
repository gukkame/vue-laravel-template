<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Retrieve all users and return them as JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUsers()
    {
        Log::info('Received request to get all users');
        
        $users = User::all();
        Log::info('Users: ' . $users->toJson());
        return response()->json($users);
    }
}
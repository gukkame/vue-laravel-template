<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/getAllUsers', [UserController::class, 'getAllUsers']);
Route::post('/addNewUser', [UserController::class, 'addNewUser']);
Route::delete('/deleteUser', [UserController::class, 'deleteUser']);
Route::put('/editUser', [UserController::class, 'editUser']);
Route::get('/searchUser', [UserController::class, 'searchUser']);
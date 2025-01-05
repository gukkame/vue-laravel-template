
<?php
// The api.php file is used to define routes that are intended for API endpoints. These routes typically return JSON responses and are used for the backend of the application, often consumed by frontend applications or external clients. 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/saveUser', [UserController::class, 'store']);
Route::get('/getAllUsers', [UserController::class, 'index']);

Route::get('/greeting', function () {
    return 'Hello World 2';
});

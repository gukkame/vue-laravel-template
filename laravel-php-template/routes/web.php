<?php
// The web.php file is used to define routes that are intended for web interfaces. These routes typically return HTML views and are used for the frontend of the application.

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/greeting', function () {
    return 'Hello World';
});


Route::get('/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');


<?php

use App\Http\Controllers\Api\{
    CategoryController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('categories', CategoryController::class);

Route::get('/', function () {
    return response()->json(['message' => 'success']);
});

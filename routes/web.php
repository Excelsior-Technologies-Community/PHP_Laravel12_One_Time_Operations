<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OperationController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/operations', [OperationController::class, 'index']);
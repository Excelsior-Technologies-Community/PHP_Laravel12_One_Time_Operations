<?php
// C:\xampp\htdocs\PHP_Laravel12_One_Time_Operations\routes\web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\OperationExecutionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/operations', [OperationController::class, 'index'])->name('operations.index');

// POST methods (for form submissions)
Route::post('/operations/execute-pending', [OperationExecutionController::class, 'executePending'])->name('operations.execute-pending');
Route::get('/operations/create', [OperationExecutionController::class, 'createOperation'])->name('operations.create');
Route::post('/operations/{operation}/execute', [OperationExecutionController::class, 'execute'])->name('operations.execute');
Route::delete('/operations/{operation}/delete', [OperationExecutionController::class, 'deleteOperation'])->name('operations.delete');
Route::get('/logs/clear', [OperationExecutionController::class, 'clearLogs'])->name('logs.clear');

// Temporary GET method for testing (remove in production)
Route::get('/operations/execute-pending', [OperationExecutionController::class, 'executePending']);
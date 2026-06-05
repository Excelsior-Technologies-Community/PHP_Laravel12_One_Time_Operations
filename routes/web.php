<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\OperationExecutionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/operations', [OperationController::class, 'index'])->name('operations.index');

Route::post('/operations/create', [OperationExecutionController::class, 'createOperation'])->name('operations.create');
Route::post('/operations/{id}/approve', [OperationExecutionController::class, 'approve'])->name('operations.approve');
Route::post('/operations/{operation}/execute', [OperationExecutionController::class, 'execute'])->name('operations.execute');
Route::post('/operations/execute-pending', [OperationExecutionController::class, 'executePending'])->name('operations.execute-pending');
Route::delete('/operations/{operation}/delete', [OperationExecutionController::class, 'deleteOperation'])->name('operations.delete');


Route::get('/logs/clear', [OperationExecutionController::class, 'clearLogs'])->name('logs.clear');


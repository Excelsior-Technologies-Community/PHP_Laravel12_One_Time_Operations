<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\OneTimeOperation;
use App\Models\OperationLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

Schedule::call(function () {
  
    $operations = OneTimeOperation::whereNull('ran_at')
        ->where('is_approved', true)
        ->get();

    foreach ($operations as $op) {
        try {
       
            
            DB::table('one_time_operations')
                ->where('id', $op->id)
                ->update(['ran_at' => Carbon::now()]);

            OperationLog::create([
                'operation_id' => $op->id,
                'operation_name' => $op->operation,
                'status' => 'success',
                'message' => 'Scheduled execution successful',
                'executed_at' => Carbon::now()
            ]);
            
        } catch (\Exception $e) {
            OperationLog::create([
                'operation_id' => $op->id,
                'operation_name' => $op->operation,
                'status' => 'failed',
                'message' => 'Scheduled execution failed: ' . $e->getMessage(),
                'executed_at' => Carbon::now()
            ]);
        }
    }
})->daily();
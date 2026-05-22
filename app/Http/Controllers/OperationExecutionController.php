<?php
// C:\xampp\htdocs\PHP_Laravel12_One_Time_Operations\app\Http\Controllers\OperationExecutionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OperationLog;
use Carbon\Carbon;

class OperationExecutionController extends Controller
{
    public function executePending()
    {
        $pendingOps = DB::table('one_time_operations')
            ->whereNull('ran_at')
            ->get();

        if ($pendingOps->isEmpty()) {
            return redirect()->route('operations.index')
                ->with('info', 'No pending operations found!');
        }

        $executed = 0;
        $failed = 0;

        foreach ($pendingOps as $op) {
            try {
                DB::table('one_time_operations')
                    ->where('id', $op->id)
                    ->update(['ran_at' => Carbon::now()]);

                OperationLog::create([
                    'operation_name' => $op->operation,
                    'status' => 'success',
                    'message' => 'Operation executed successfully',
                    'executed_at' => Carbon::now()
                ]);

                $executed++;

            } catch (\Exception $e) {
                OperationLog::create([
                    'operation_name' => $op->operation,
                    'status' => 'failed',
                    'message' => $e->getMessage(),
                    'executed_at' => Carbon::now()
                ]);
                $failed++;
            }
        }

        return redirect()->route('operations.index')
            ->with('success', "Executed: {$executed} | Failed: {$failed}");
    }

    public function createOperation(Request $request)
    {
        $request->validate([
            'operation_name' => 'required|string|unique:one_time_operations,operation',
        ]);

        DB::table('one_time_operations')->insert([
            'operation' => $request->operation_name,
            'ran_at' => null
        ]);

        return redirect()->route('operations.index')
            ->with('success', "Operation '{$request->operation_name}' created successfully!");
    }

    public function execute($operation)
    {
        try {
            DB::table('one_time_operations')
                ->where('operation', $operation)
                ->update(['ran_at' => Carbon::now()]);

            OperationLog::create([
                'operation_name' => $operation,
                'status' => 'success',
                'message' => 'Operation executed successfully',
                'executed_at' => Carbon::now()
            ]);

            return redirect()->route('operations.index')
                ->with('success', "Operation '{$operation}' executed successfully!");

        } catch (\Exception $e) {
            OperationLog::create([
                'operation_name' => $operation,
                'status' => 'failed',
                'message' => $e->getMessage(),
                'executed_at' => Carbon::now()
            ]);

            return redirect()->route('operations.index')
                ->with('error', "Failed to execute '{$operation}': " . $e->getMessage());
        }
    }

    public function deleteOperation($operation)
    {
        DB::table('one_time_operations')
            ->where('operation', $operation)
            ->delete();

        return redirect()->route('operations.index')
            ->with('success', "Operation '{$operation}' deleted!");
    }

    public function clearLogs()
    {
        OperationLog::truncate();

        return redirect()->route('operations.index')
            ->with('success', 'All logs cleared successfully!');
    }
}
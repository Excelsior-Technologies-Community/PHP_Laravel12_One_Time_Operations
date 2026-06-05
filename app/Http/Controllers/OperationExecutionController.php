<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OperationLog;
use Carbon\Carbon;

class OperationExecutionController extends Controller
{
    /**
     * Execute all pending and approved operations.
     */
    public function executePending()
    {
        $pendingOps = DB::table('one_time_operations')
            ->whereNull('ran_at')
            ->where('is_approved', true) 
            ->get();

        if ($pendingOps->isEmpty()) {
            return redirect()->route('operations.index')
                ->with('info', 'No approved pending operations found!');
        }

        $executed = 0;
        $failed = 0;

        foreach ($pendingOps as $op) {
            try {
                // Update the execution time
                DB::table('one_time_operations')
                    ->where('id', $op->id)
                    ->update(['ran_at' => Carbon::now()]);

                // Create a success log
                OperationLog::create([
                    'operation_id'   => $op->id,
                    'operation_name' => $op->operation,
                    'status'         => 'success',
                    'message'        => 'Operation executed successfully.',
                    'executed_at'    => Carbon::now()
                ]);

                $executed++;
            } catch (\Exception $e) {
                // Create a failure log
                OperationLog::create([
                    'operation_id'   => $op->id,
                    'operation_name' => $op->operation,
                    'status'         => 'failed',
                    'message'        => 'Error: ' . $e->getMessage(),
                    'executed_at'    => Carbon::now()
                ]);
                $failed++;
            }
        }

        return redirect()->route('operations.index')
            ->with('success', "Executed: {$executed} | Failed: {$failed}");
    }

    /**
     * Approve an operation.
     */
    public function approve($id)
    {
        DB::table('one_time_operations')
            ->where('id', $id)
            ->update(['is_approved' => true]);

        return redirect()->route('operations.index')
            ->with('success', 'Operation approved successfully!');
    }

    /**
     * Create a new operation.
     */
    public function createOperation(Request $request)
    {
        $request->validate([
            'operation_name' => 'required|string|unique:one_time_operations,operation',
        ]);

        DB::table('one_time_operations')->insert([
            'operation'   => $request->operation_name,
            'ran_at'      => null,
            'is_approved' => false
        ]);

        return redirect()->route('operations.index')
            ->with('success', "Operation '{$request->operation_name}' created! Please approve it to execute.");
    }

    /**
     * Execute a specific operation.
     */
    public function execute($operation)
    {
        $op = DB::table('one_time_operations')->where('operation', $operation)->first();

        // Check if operation exists and is approved
        if (!$op || !$op->is_approved) {
            return redirect()->route('operations.index')
                ->with('error', "Operation is not approved or not found!");
        }

        try {
            DB::table('one_time_operations')
                ->where('operation', $operation)
                ->update(['ran_at' => Carbon::now()]);

            OperationLog::create([
                'operation_id'   => $op->id,
                'operation_name' => $operation,
                'status'         => 'success',
                'message'        => 'Operation executed successfully.',
                'executed_at'    => Carbon::now()
            ]);

            return redirect()->route('operations.index')
                ->with('success', "Operation '{$operation}' executed successfully!");

        } catch (\Exception $e) {
            OperationLog::create([
                'operation_id'   => $op->id,
                'operation_name' => $operation,
                'status'         => 'failed',
                'message'        => 'Error: ' . $e->getMessage(),
                'executed_at'    => Carbon::now()
            ]);

            return redirect()->route('operations.index')
                ->with('error', "Operation '{$operation}' failed: " . $e->getMessage());
        }
    }

    /**
     * Delete an operation.
     */
    public function deleteOperation($operation)
    {
        DB::table('one_time_operations')->where('operation', $operation)->delete();

        return redirect()->route('operations.index')
            ->with('success', "Operation '{$operation}' deleted!");
    }

    /**
     * Clear all execution logs.
     */
    public function clearLogs()
    {
        OperationLog::truncate();

        return redirect()->route('operations.index')
            ->with('success', 'All logs cleared successfully!');
    }
}
<?php

use App\Models\User;
use App\Models\OperationLog;
use Illuminate\Support\Facades\DB;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation {
    protected bool $async = false;

    public function process(): void
    {
        try {

            // ✅ MAIN OPERATION
            User::firstOrCreate([
                'email' => 'awesome@example.com'
            ], [
                'name' => 'Awesome User',
                'password' => bcrypt('password123'),
            ]);

            // ✅ SAVE OPERATION STATUS (IMPORTANT 🔥)
            DB::table('one_time_operations')->updateOrInsert(
                ['operation' => 'AddAwesomeUser'],
                ['ran_at' => now()]
            );

            // ✅ SUCCESS LOG
            OperationLog::create([
                'operation_name' => class_basename(static::class),
                'status' => 'success',
                'message' => 'Executed successfully',
                'executed_at' => now()
            ]);

        } catch (\Exception $e) {

            // ❌ FAILURE LOG
            OperationLog::create([
                'operation_name' => class_basename(static::class),
                'status' => 'failed',
                'message' => $e->getMessage(),
                'executed_at' => now()
            ]);

            throw $e;
        }
    }
};
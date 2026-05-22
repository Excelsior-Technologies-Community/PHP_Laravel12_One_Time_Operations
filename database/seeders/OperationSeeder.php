<?php
// C:\xampp\htdocs\PHP_Laravel12_One_Time_Operations\database\seeders\OperationSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OperationSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        DB::table('one_time_operations')->truncate();
        DB::table('operation_logs')->truncate();

        // Insert sample operations
        DB::table('one_time_operations')->insert([
            ['operation' => 'cleanup_sessions', 'ran_at' => null],
            ['operation' => 'clear_cache', 'ran_at' => null],
            ['operation' => 'update_users', 'ran_at' => null],
            ['operation' => 'migrate_data', 'ran_at' => null],
        ]);

        // Insert sample completed operation
        DB::table('one_time_operations')->insert([
            ['operation' => 'initial_setup', 'ran_at' => Carbon::now()->subDays(2)]
        ]);

        // Insert sample logs
        DB::table('operation_logs')->insert([
            [
                'operation_name' => 'initial_setup',
                'status' => 'success',
                'message' => 'Initial setup completed successfully',
                'executed_at' => Carbon::now()->subDays(2),
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2)
            ]
        ]);
    }
}
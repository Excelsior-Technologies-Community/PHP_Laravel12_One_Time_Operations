<?php
// C:\xampp\htdocs\PHP_Laravel12_One_Time_Operations\app\Http\Controllers\OperationController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\OperationLog;

class OperationController extends Controller
{
    public function index()
    {
        $operations = DB::table('one_time_operations')->get();
        
        $stats = [
            'total' => $operations->count(),
            'completed' => $operations->whereNotNull('ran_at')->count(),
            'pending' => $operations->whereNull('ran_at')->count(),
            'success_rate' => $operations->count() > 0 
                ? round(($operations->whereNotNull('ran_at')->count() / $operations->count()) * 100, 2)
                : 0
        ];

        $logs = OperationLog::latest()->paginate(10);

        return view('operations.index', compact('operations', 'logs', 'stats'));
    }
}
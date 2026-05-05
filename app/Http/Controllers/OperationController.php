<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\OperationLog;

class OperationController extends Controller
{
    public function index()
    {
        // All one-time operations (from package table)
        $operations = DB::table('one_time_operations')->get();

        // Your logs
        $logs = OperationLog::latest()->get();

        return view('operations.index', compact('operations', 'logs'));
    }
}
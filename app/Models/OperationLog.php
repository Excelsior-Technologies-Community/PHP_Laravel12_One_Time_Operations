<?php
// C:\xampp\htdocs\PHP_Laravel12_One_Time_Operations\app\Models\OperationLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationLog extends Model
{
    protected $table = 'operation_logs';

    protected $fillable = [
        'operation_name',
        'status',
        'message',
        'executed_at'
    ];

    protected $casts = [
        'executed_at' => 'datetime',
    ];
}
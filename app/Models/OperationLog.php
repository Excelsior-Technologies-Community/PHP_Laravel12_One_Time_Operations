<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationLog extends Model
{
    protected $table = 'operation_logs';

    protected $fillable = [
        'operation_id',
        'operation_name',
        'status',
        'message',
        'output',
        'executed_at'
    ];

    protected $casts = [
        'executed_at' => 'datetime',
    ];

    public function operation()
    {
        return $this->belongsTo(OneTimeOperation::class, 'operation_id');
    }
}
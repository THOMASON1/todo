<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'task_id', 'name', 'description', 'priority','status',
        'due_date','action', 'changed_at', 'changed_by'
    ];
}

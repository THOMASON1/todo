<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\TaskHistory;
use Illuminate\Support\Facades\Auth;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        TaskHistory::create([
            'task_id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'status' => $task->status,
            'priority' => $task->priority,
            'due_date' => $task->due_date,
            'action' => 'CREATE',
            'changed_at' => now(),
            'changed_by' => Auth::id(),
        ]);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        \Log::info('Zadanie zaktualizowane.');
        TaskHistory::create([
            'task_id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'status' => $task->status,
            'priority' => $task->priority,
            'due_date' => $task->due_date,
            'action' => 'UPDATE',
            'changed_at' => now(),
            'changed_by' => Auth::id(),
        ]);
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        \Log::info('Zadanie skasowane.');
        TaskHistory::create([
            'task_id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'status' => $task->status,
            'priority' => $task->priority,
            'due_date' => $task->due_date,
            'action' => 'DELETE',
            'changed_at' => now(),
            'changed_by' => Auth::id(),
        ]);
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}

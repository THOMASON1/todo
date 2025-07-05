<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\TaskHistory;

class TaskHistoryController extends Controller
{
    public function show($taskId)
    {
        $task = Task::find($taskId);

        if (!$task || $task->user_id !== Auth::id()) {
            abort(403, 'Nie masz dostępu do tej historii zadania.');
        }

        $history = TaskHistory::where('task_id', $taskId)
                              ->orderBy('changed_at', 'desc')
                              ->get();

        return view('task-history.index', compact('history', 'taskId'));
    }
}

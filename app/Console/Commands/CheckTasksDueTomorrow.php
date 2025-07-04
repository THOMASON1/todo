<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Task;
use App\Mail\TaskDueTomorrowMail;

class CheckTasksDueTomorrow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:check-due-tomorrow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sprawdź zadania, które mają termin na 1 dzień przed dzisiejszym.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $tomorrow = $today->addDay();

        $tasks = Task::where('due_date', '=', $tomorrow)->get();

        foreach ($tasks as $task) {
            $this->info('Wysyłam do: '.$task->user->email);
            Mail::to($task->user->email)->send(new TaskDueTomorrowMail($task));
        }

        $this->info('Nadchodzące zadania zostały sprawdzone i powiadomienia mailowe wysłane.');
    }
}

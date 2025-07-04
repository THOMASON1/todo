<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tasks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request->input('name'), 
            'description' => $request->input('description'),
            'priority' => $request->input('priority'),
            'status' => $request->input('status'),
            'due_date' => $request->input('due_date'),
            'user_id' => Auth::user()->id
        ];
        $task = Task::create($data);
        return redirect()->route('tasks')->with('success', 'Zadanie zostało dodane!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to-do,in progress,done',
            'due_date' => 'required|date',
        ]);

        $task = Task::where('id', $id);
        $task->update($validated);

        return redirect()->route('tasks')->with('success', 'Zadanie zostało edytowane!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $task->delete();
        return redirect()->route('tasks')->with('success', 'Zadanie zostało usunięte!');
    }

    public function getTasksData()
    {
        $tasks = Auth::user()->tasks;
        return DataTables::of($tasks)->make(true);
    }

    public function generatePublicLink($userId)
    {
        // Znajdź użytkownika
        $user = User::findOrFail($userId);

        // Generowanie tokena
        $token = Str::random(60);

        // Przechowywanie tokena w cache przez 1 godzinę
        Cache::put("user-tasks-public-{$token}", $userId, now()->addHour());

        // Tworzenie linku
        $link = route('tasks.public', ['token' => $token]);

        // Zwrócenie odpowiedzi JSON z linkiem
        return response()->json(['link' => $link]);
    }

    public function showPublicTasks($token)
    {
        // Sprawdzanie, czy token istnieje i jest ważny
        if (!Cache::has("user-tasks-public-{$token}")) {
            abort(404, 'Link wygasł lub jest nieprawidłowy.');
        }

        // Pobranie użytkownika na podstawie tokena
        $userId = Cache::get("user-tasks-public-{$token}");
        $user = User::findOrFail($userId);

        // Pobranie zadań użytkownika
        $tasks = $user->tasks;
        $userName = $user->name;

        // Zwrócenie danych zadań
        return view('tasks.public', compact('tasks', 'userName'));
    }

    public function addToCalendar(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        try {
            $event = new Event;
            $event->name = $validated['name'];
            // dd(Carbon::parse($validated['due_date']));
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $validated['due_date'], 'Europe/Warsaw');
            $event->startDateTime = $startDateTime;
            $event->endDateTime = $startDateTime->addHour();
            $event->description = $validated['description'] ?? '';
            $event->save();

            return redirect()->back()->with('success', 'Zadanie dodane do kalendarza Google.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Wystąpił błąd: ' . $e->getMessage());
        }
    }
}

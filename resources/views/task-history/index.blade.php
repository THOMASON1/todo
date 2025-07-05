<!-- resources/views/task-history.blade.php -->

@extends('layouts.app') <!-- Zakładając, że masz główny layout -->

@section('content')
    <div class="container">
        <h1>Historia zadania o ID: {{ $taskId }}</h1>

        @if ($history->isEmpty())
            <div class="alert alert-warning">
                Brak historii dla tego zadania.
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nazwa zadania</th>
                        <th>Opis</th>
                        <th>Priorytet</th>
                        <th>Status</th>
                        <th>Termin wykonania</th>
                        <th>Data zmiany</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($history as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $task->name }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->priority }}</td>
                            <td>{{ $task->status }}</td>
                            <td>{{ $task->due_date }}</td>
                            <td>{{ $task->changed_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('tasks') }}" class="btn btn-primary mt-3">Wróć do listy zadań</a>
    </div>
@endsection

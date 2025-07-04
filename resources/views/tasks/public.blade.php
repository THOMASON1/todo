@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista zadań użytkownika {{ $userName }}</h2>

    @if($tasks->isEmpty())
        <p>Brak zadań do wyświetlenia.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nazwa zadania</th>
                    <th>Opis</th>
                    <th>Priorytet</th>
                    <th>Status</th>
                    <th>Termin wykonania</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->priority }}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->due_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

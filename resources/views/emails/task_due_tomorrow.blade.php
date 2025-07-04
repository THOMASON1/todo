<!-- resources/views/emails/task_due_tomorrow.blade.php -->

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Przypomnienie o zadaniu - termin na jutro</title>
</head>
<body>
    <h1>Przypomnienie o zadaniu: {{ $task->name }}</h1>
    <p>Opis zadania: {{ $task->description }}</p>
    <p><strong>Termin wykonania:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') }}</p>
    <p>To zadanie ma termin na dzień <strong>jutro</strong>, prosimy o jego wykonanie.</p>
</body>
</html>

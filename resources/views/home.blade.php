@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Witamy!') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <p class="lead mt-3">
                    Zarządzaj swoimi zadaniami sprawnie i wygodnie. <br>
                    Dodawaj, edytuj, usuwaj i śledź zmiany w historii. <br>
                    Synchronizuj zadania z Google Kalendarzem i bądź zawsze na bieżąco!
                </p>
                <a href="{{ route('tasks') }}" class="btn btn-primary mt-4">Przejdź do listy zadań</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

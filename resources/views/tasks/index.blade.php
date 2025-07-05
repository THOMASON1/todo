@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Moje zadania</h2>
</br>
<button id="generateLinkButton" class="btn btn-primary">Generuj link publiczny</button>
<!-- <p id="publicLink"> -->
<p class="fs-5 text-muted" id="publicLink"></p>
</br>
<table id="todo-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nazwa</th>
            <th>Opis</th>
            <th>Priorytet</th>
            <th>Status</th>
            <th>Termin wykonania</th>
            <th>Dodano</th>
            <th>Akcje</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>
                <select class="column-filter" data-column="3">
                    <option value="">Wszystkie</option>
                    <option value="low">low</option>
                    <option value="medium">medium</option>
                    <option value="high">high</option>
                </select>
            </th>
            <th>
                <select class="column-filter" data-column="4">
                    <option value="">Wszystkie</option>
                    <option value="to-do">to-do</option>
                    <option value="in progress">in progress</option>
                    <option value="done">done</option>
                </select>
            </th>
            <th>
                <input type="date" class="column-filter" data-column="5" />
            </th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
</div>

<!-- Modal do dodawania zadania -->
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Dodaj nowe zadanie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formularz dodawania zadania -->
                <form id="taskForm" action="/tasks/store" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="task-name">Nazwa zadania</label>
                        <input type="text" class="form-control" id="task-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="task-description">Opis</label>
                        <textarea class="form-control" id="task-description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="task-priority">Priorytet</label>
                        <select class="form-control" id="task-priority" name="priority" required>
                            <option value="low">low</option>
                            <option value="medium">medium</option>
                            <option value="high">high</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="task-status">Status</label>
                        <select class="form-control" id="task-status" name="status" required>
                            <option value="to-do">to-do</option>
                            <option value="in progress">in progress</option>
                            <option value="done">done</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="task-due-date">Termin wykonania</label>
                        <input type="datetime-local" class="form-control" id="task-due-date" name="due_date" required>
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Zapisz zadanie</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="editTaskForm" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" id="edit-id">

    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edytuj zadanie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nazwa zadania</label>
                        <input type="text" name="name" id="edit-name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-description" class="form-label">Opis</label>
                        <textarea name="description" id="edit-description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit-priority" class="form-label">Priorytet</label>
                        <select name="priority" id="edit-priority" class="form-control">
                            <option value="low">low</option>
                            <option value="medium">medium</option>
                            <option value="high">high</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit-status" class="form-label">Status</label>
                        <select name="status" id="edit-status" class="form-control">
                            <option value="to-do">to-do</option>
                            <option value="in progress">in progress</option>
                            <option value="done">done</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit-due-date" class="form-label">Termin wykonania</label>
                        <input type="datetime-local" name="due_date" id="edit-due-date" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                    <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>

<script>
    var table = $('#todo-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: '{{ route('tasks.data') }}',
            columns: [
                { data: 'id', name: 'id', visible: false },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'priority', name: 'priority' },
                { data: 'status', name: 'status_opis' },
                { data: 'due_date', name: 'due_date'
                    ,render: function (data) {
                        return moment(data).format('YYYY-MM-DD HH:mm');
                    } 
                },
                { data: 'created_at', name: 'created_at'
                    ,render: function (data) {
                        return moment(data).format('YYYY-MM-DD HH:mm');
                    } 
                },
                {
                    data: 'id',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                            return `
                                <div style="display: flex; gap: 5px;">
                                    <form action="{{ route('calendar.add') }}" method="POST" >
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="name" value="${row.name}">
                                        <input type="hidden" name="description" value="${row.description}">
                                        <input type="hidden" name="due_date" value="${row.due_date}">
                                        <button type="submit" class="btn btn-sm btn-success" >
                                            <i class="fa fa-plus"></i> Kalendarz
                                        </button>
                                    </form>
                                    <button class="btn btn-sm btn-primary editTaskBtn" data-id="${row.id}" data-name="${row.name}" data-description="${row.description}" data-priority="${row.priority}" data-status="${row.status}" data-duedate="${row.due_date}">
                                            <i class="fa fa-edit"></i> Edytuj
                                    </button>
                                    <form action="/task-history/${row.id}" method="GET">
                                        <button type="submit" class="btn btn-sm btn-info">
                                            <i class="fa fa-history"></i> Historia
                                        </button>
                                    </form>
                                    <form action="/tasks/${data}" method="POST" class="delete-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć ten wpis?')">
                                            <i class="fa fa-trash me-1"></i> Usuń
                                        </button>
                                    </form>
                                </div>
                            `;
                    }
                }
            ],
            dom: 'Brtip',
            searching: true,
            buttons: [
                {
                    text: 'Dodaj zadanie',
                    className: 'btn btn-success',
                    action: function ( e, dt, node, config ) {
                        $('#addTaskModal').modal('show');
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('dt-button');
                    }
                }
            ],
            language: {
                zeroRecords: "Brak pasujących rekordów",
                sProcessing: "Przetwarzanie...",
                sLengthMenu: "Pokaż _MENU_ rekordów",
                sSearch: "Szukaj:",
                sEmptyTable: "Brak danych w tabeli",
                sInfo: "Wyświetlanie rekordów od _START_ do _END_ z _TOTAL_ rekordów",
                sInfoEmpty: "Wyświetlanie 0 do 0 z 0 rekordów",
                sInfoFiltered: "(filtrowanie spośród _MAX_ rekordów)",
                sLoadingRecords: "Ładowanie...",
                oPaginate: {
                    sFirst: "Pierwsza",
                    sPrevious: "Poprzednia",
                    sNext: "Następna",
                    sLast: "Ostatnia"
                }
            },
            initComplete: function() {
                
                // Dodajemy eventy do filtrów po zainicjowaniu DataTables
                $('.column-filter').on('keyup change', function() {
                    var columnIndex = $(this).data('column'); // Pobranie indeksu kolumny
                    var columnValue = $(this).val(); // Pobranie wartości z pola filtrującego
                    console.log(columnValue);
                    console.log(columnIndex);

                    const columnData = table.column(columnIndex).search(columnValue).toArray();
                    console.log('Dane z kolumny:', columnData);
                    // console.log('Dane z kolumny:', columnData);
                    $('#todo-table').DataTable().column(columnIndex).search(columnValue).draw(); // Filtrowanie na poziomie kolumny
                });

                $('#todo-table tbody').on('click', '.editTaskBtn', function () {
                    const taskId = $(this).data('id');

                    $('#editTaskForm').attr('action', `/tasks/${taskId}`);
                    $('#edit-id').val(taskId);
                    $('#edit-name').val($(this).data('name'));
                    $('#edit-description').val($(this).data('description'));
                    $('#edit-priority').val($(this).data('priority'));
                    $('#edit-status').val($(this).data('status'));
                    $('#edit-due-date').val($(this).data('duedate'));

                    $('#editTaskModal').modal('show');
                });
            }
        });
</script>
<script>
    $(document).ready(function() {
        $('#generateLinkButton').click(function() {
            var userId = {{ Auth::user()->id }}; // ID aktualnie zalogowanego użytkownika

            $.ajax({
                url: '/generate-public-link/' + userId, // Ścieżka do metody w kontrolerze
                method: 'GET',
                success: function(response) {
                    // Po udanym wygenerowaniu linku, wyświetlamy go w paragrafie
                    $('#publicLink').html('Link publiczny do Twoich zadań: <a href="' + response.link + '" target="_blank">' + response.link + '</a>');
                },
                error: function() {
                    alert('Wystąpił błąd podczas generowania linku.');
                }
            });
        });
    });
</script>
@endpush
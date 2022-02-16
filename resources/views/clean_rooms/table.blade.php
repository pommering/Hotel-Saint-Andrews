<div class="table-responsive">
    <table class="table m-0" id="cleanRooms-table">
        <thead>
            <tr>
                <th>Número do quarto</th>
                <th>Funcionario responsável</th>
                <th>Tarefas feita</th>
                <th>Início</th>
                <th>Término</th>
                <th colspan="3">Ação</th>
            </tr>
        </thead>
        <tbody>
        @foreach($cleanRooms as $cleanRoom)

            <tr>
                <td>{{ $cleanRoom->room_number }}</td>
                <td>{{ $cleanRoom->user->name }}</td>
                <td>{{ implode (", ", $cleanRoom->tasksDone) }}</td>
                <td>{{ date('d/m/Y H:i:s', strtotime($cleanRoom->start_date)) }}</td>
                <td>{{ date('d/m/Y H:i:s', $cleanRoom->end_date) }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['cleanRooms.destroy', $cleanRoom->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('cleanRooms.show', [$cleanRoom->id]) }}"
                        class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @can('manager')
                        <a href="{{ route('cleanRooms.edit', [$cleanRoom->id]) }}"
                        class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        @endif
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

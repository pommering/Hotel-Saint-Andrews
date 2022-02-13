<div class="table-responsive">
    <table class="table" id="cleanRooms-table">
        <thead>
            <tr>
                <th>Número do quarto</th>
                <th>Usuário responsável</th>
                <th>Tarefa feita</th>
                <th>Início</th>
                <th>Término</th>
                <th colspan="3">Ação</th>
            </tr>
        </thead>
        <tbody>
        @foreach($cleanRooms as $cleanRoom)
            <tr>
                <td>{{ $cleanRoom->room_number }}</td>
            <td>{{ $cleanRoom->user_id }}</td>
            <td>{{ $cleanRoom->activitie_id }}</td>
            <td>{{ date('d/m/Y H:i:s', strtotime($cleanRoom->start_date)) }}</td>
            <td>{{ date('d/m/Y H:i:s', strtotime($cleanRoom->end_date)) }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['cleanRooms.destroy', $cleanRoom->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('cleanRooms.show', [$cleanRoom->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('cleanRooms.edit', [$cleanRoom->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

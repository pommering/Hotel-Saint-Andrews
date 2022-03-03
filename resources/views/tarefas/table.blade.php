<div class="table-responsive">
    <table class="table m-0" id="tarefas-table">
        <thead>
            <tr>
                <th>Tarefas</th>
                <th>Obrigatório</th>
                @can('manager')
                <th colspan="2">Ação</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach($tarefas as $tarefas)
            <tr>
                <td>{{ $tarefas->assignment }}</td>
                <td>{{ $tarefas->mandatory ? 'Sim' : 'Não' }}</td>
                @can('manager')
                <td width="120">
                    {!! Form::open(['route' => ['tarefas.destroy', $tarefas->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('tarefas.edit', [$tarefas->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

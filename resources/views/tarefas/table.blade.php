<div class="table-responsive">
    <table class="table" id="tarefas-table">
        <thead>
        <tr>
            <th>Assignment</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tarefas as $tarefas)
            <tr>
                <td>{{ $tarefas->assignment }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['tarefas.destroy', $tarefas->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('tarefas.show', [$tarefas->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('tarefas.edit', [$tarefas->id]) }}"
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

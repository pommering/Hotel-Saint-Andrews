<div class="table-responsive">
    <table class="table m-0" id="cleanRooms-table">
        <thead>
            <tr>
                <th>Posição</th>
                <th>Nome do Funcionário</th>
                <th>Quantidade de Tarefas Realizadas</th>
                <th>Tempo total trabalho</th>
                <th>Média da Atividade mais rápida realizada</th>
                <th>Média da Atividade mais demorado realizado</th>
            </tr>
        </thead>
        <tbody>
        @foreach($ranking as $key => $position)
            <tr>
                <td>#{{ $key+1 }}</td>
                <td>{{ $position['name'] }}</td>
                <td>{{ $position['total_tasks'] }}</td>
                <td>{{ date( 'H:i:s', strtotime($position['total_works_time'])) }}</td>
                <td>Tarefa: {{ $position['task_max']['name_task'] }}  <br/>  Media de Tempo: {{ date( 'H:i:s', strtotime($position['task_max']['time'])) }}</td>
                <td>Tarefa: {{ $position['task_min']['name_task'] }} <br/>  Media de Tempo: {{ date( 'H:i:s', strtotime($position['task_min']['time'])) }} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

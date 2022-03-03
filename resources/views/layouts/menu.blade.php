@can('manager')
<li class="nav-item">
    <a href="{{ route('ranking.index') }}" class="nav-link {{ Request::is('ranking*') ? 'active' : '' }}">
        <i class="fa fa-star mr-1"></i>
        <p>Ranking</p>
    </a>
</li>
@endif

@can('manager')
<li class="nav-item">
    <a href="{{ route('users.index') }}"class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <i class="fa fa-user mr-1"></i>
        <p>Usuários</p>
    </a>
</li>
@endif

@can('manager')
<li class="nav-item">
    <a href="{{ route('tarefas.index') }}" class="nav-link {{ Request::is('tarefas*') ? 'active' : '' }}">
        <i class="fa fa-coffee mr-1"></i>
        <p>Tarefas</p>
    </a>
</li>
@endif

<li class="nav-item">
    <a href="{{ route('cleanRooms.index') }}"class="nav-link {{ Request::is('cleanRooms*') ? 'active' : '' }}">
        <i class="fa fa-check mr-1"></i>
        <p>Quartos limpos</p>
    </a>
</li>



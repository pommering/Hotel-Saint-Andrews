<li class="nav-item">
    <a href="{{ route('users.index') }}"
       class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <p>Usuários</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('tarefas.index') }}"
       class="nav-link {{ Request::is('tarefas*') ? 'active' : '' }}">
        <p>Tarefas</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('cleanRooms.index') }}"
       class="nav-link {{ Request::is('cleanRooms*') ? 'active' : '' }}">
        <p>Clean Rooms</p>
    </a>
</li>



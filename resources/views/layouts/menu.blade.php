<li class="nav-item">
    <a href="{{ route('usuarios.index') }}"
       class="nav-link {{ Request::is('usuarios*') ? 'active' : '' }}">
        <p>Usuarios</p>
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



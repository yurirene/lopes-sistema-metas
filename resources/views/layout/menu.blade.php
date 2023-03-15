<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('home') }}"><img src="/img/logo_empresa.png" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ request()->is('home') ? 'active' : '' }} ">
                    <a href="{{ route('home') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @can('menu', ['master'])
                <li class="sidebar-item {{ request()->is('planilha*') ? 'active' : '' }}">
                    <a href="{{ route('planilha.index') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-excel"></i>
                        <span>Planilhas</span>
                    </a>
                </li>
                @endcan

                @can('menu', ['master', 'gerente'])
                <li class="sidebar-item {{ request()->is('supervisores*') ? 'active' : '' }}">
                    <a href="{{ route('supervisores.index') }}" class='sidebar-link'>
                        <i class="bi bi-person-square"></i>
                        <span>Supervisores</span>
                    </a>
                </li>
                @endcan

                @can('menu', ['supervisor'])
                <li class="sidebar-item {{ request()->is('vendedor*') ? 'active' : '' }}">
                    <a href="{{ route('vendedores.index') }}" class='sidebar-link'>
                        <i class="bi bi-person-badge"></i>
                        <span>Vendedores</span>
                    </a>
                </li>
                @endcan

                @can('menu', ['master'])
                <li class="sidebar-item {{ request()->is('usuarios*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-people"></i>
                        <span>Usuários</span>
                    </a>
                </li>
                @endcan

                <li class="sidebar-item {{ request()->is('relatorios*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-lock"></i>
                        <span>Trocar Senha</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('relatorios*') ? 'active' : '' }}">
                    {!! Form::open(['method' => 'POST', 'route' => 'logout', 'class' => 'form-horizontal', 'id' => 'logout-form']) !!}
                    <a href="#" id="logout" class='sidebar-link'>
                        <i class="bi bi-door-open-fill"></i>
                        <span>Logout</span>
                    </a>
                    {!! Form::close() !!}

                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>

@push('js')

<script>
    $('#logout').on('click', function() {
        $('#logout-form').submit();
    });
</script>
@endpush

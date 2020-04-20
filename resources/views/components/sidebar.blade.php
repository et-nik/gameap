<p class="left-menu-group">{{ __('sidebar.control') }}</p>
<p class="left-menu-group-mini">—</p>

<ul class="page-sidebar-menu">
    <li title="{{ __('sidebar.servers') }}" data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
        <a href="{{ route('servers') }}">
            <i class="fas fa-server"></i>
            <span class="menu-item-label">{{ __('sidebar.servers') }}</span>
        </a>
    </li>
</ul>

@can('admin roles & permissions')
    <p class="left-menu-group">{{ __('sidebar.admin') }}</p>
    <p class="left-menu-group-mini">—</p>

    <ul class="page-sidebar-menu">
        <li title="{{ __('sidebar.dedicated_servers') }}" data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
            <a href="{{ route('admin.dedicated_servers.index') }}">
                <i class="fas fa-hdd"></i>
                <span class="menu-item-label">{{ __('sidebar.dedicated_servers') }}</span>
            </a>
        </li>
        <li title="{{ __('sidebar.game_servers') }}" data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
            <a href="{{ route('admin.servers.index') }}">
                <i class="fas fa-server"></i>
                <span class="menu-item-label">{{ __('sidebar.game_servers') }}</span>
            </a>
        </li>
        <li title="{{ __('sidebar.games') }}" data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
            <a href="{{ route('admin.games.index') }}">
                <i class="fas fa-gamepad"></i>
                <span class="menu-item-label">{{ __('sidebar.games') }}</span>
            </a>
        </li>
        <li title="{{ __('sidebar.gdaemon_tasks') }}" data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
            <a href="{{ route('admin.gdaemon_tasks.index') }}">
                <i class="fas fa-tasks"></i>
                <span class="menu-item-label">{{ __('sidebar.gdaemon_tasks') }}</span>
            </a>
        </li>
        <li title="{{ __('sidebar.users') }}" data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
            <a href="{{ route('admin.users.index') }}">
                <i class="fas fa-users"></i>
                <span class="menu-item-label">{{ __('sidebar.users') }}</span>
            </a>
        </li>
    </ul>
@endcan

@can('admin roles & permissions')
    <p class="left-menu-group">{{ __('sidebar.gameap') }}</p>
    <p class="left-menu-group-mini">—</p>

    <ul class="page-sidebar-menu">
        <li title="{{ __('sidebar.modules') }}" data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
            <a href="{{ route('modules') }}">
                <i class="fas fa-puzzle-piece"></i>
                <span class="menu-item-label">{{ __('sidebar.modules') }}</span>
            </a>
        </li>
        <li title="{{ __('sidebar.update') }}" data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
            <a href="{{ route('update') }}">
                <i class="fas fa-sync"></i>
                <span class="menu-item-label">{{ __('sidebar.update') }}</span>
            </a>
        </li>
    </ul>
@endcan

<p class="left-menu-group">{{ __('sidebar.support') }}</p>
<p class="left-menu-group-mini">—</p>

<ul class="page-sidebar-menu">
    <li title="{{ __('sidebar.forum') }}" data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
        <a target="_blank" href="https://forum.gameap.ru">
            <i class="fas fa-comment-alt"></i>
            <span class="menu-item-label">{{ __('sidebar.forum') }}</span>
        </a>
    </li>
    <li title="{{ __('sidebar.documentation') }}" data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
        <a target="_blank" href="https://docs.gameap.ru">
            <i class="fab fa-wikipedia-w"></i>
            <span class="menu-item-label">{{ __('sidebar.documentation') }}</span>
        </a>
    </li>
    <li title="{{ __('sidebar.help') }}" data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
        <a href="{{ route('help') }}">
            <i class="fas fa-question"></i>
            <span class="menu-item-label">{{ __('sidebar.help') }}</span>
        </a>
    </li>
    <li title="{{ __('sidebar.report_bug') }}" data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
        <a href="{{ route('report_bug') }}">
            <i class="fas fa-bug"></i>
            <span class="menu-item-label">{{ __('sidebar.report_bug') }}</span>
        </a>
    </li>
</ul>

<p class="left-menu-group d-md-none">{{ __('sidebar.profile') }}</p>

<ul class="page-sidebar-menu d-md-none">
    <li>
        <a class="btn btn-dark navbar-btn" href="{{ route('profile') }}">
            <i class="fas fa-user"></i>
            <span class="menu-item-label">{{ Auth::user()->name }}</span>
        </a>
    </li>
    <li>
        {{ Form::open(['id' => 'logout-form-sm', 'url' => route('logout'), 'style'=>'display:inline']) }}
        {{ csrf_field() }}
        {{ Form::button( '<i class="fas fa-sign-out-alt"></i><span class="menu-item-label">' . __('navbar.sign_out') . '</span>' ,
        [
            'class' => 'btn btn-danger btn-logout navbar-btn',
            'type' => 'submit'
        ]
        ) }}
        {{ Form::close() }}
    </li>
</ul>

<p class="left-menu-group d-sm-none d-md-block">&nbsp;</p>

<ul class="page-sidebar-menu d-sm-none d-md-block">
    <li title="{{ __('sidebar.maximize') }}" id="left-menu-mini-btn"  data-toggle="tooltip" data-placement="left" data-container="#left-menu-tooltips">
        <a href="#">
            <i id="left-menu-mini-icon" class="fas fa-chevron-left"></i>
            <span class="menu-item-label">{{ __('sidebar.minimize') }}</span>
        </a>
    </li>
</ul>

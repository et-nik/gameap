<p class="left-menu-group">{{ __('sidebar.control') }}</p>
<p class="left-menu-group-mini">—</p>

<ul class="page-sidebar-menu">

    <li>
        <a
            class="left-menu-link"
            href="{{ route('servers') }}"
            title="{{ __('sidebar.servers') }}"
            data-bs-toggle="tooltip"
            data-bs-placement="right"
            data-bs-delay="200"
        >
            <i class="fas fa-play"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.servers') }}</span>
        </a>
    </li>
</ul>

@can('admin roles & permissions')
    <p class="left-menu-group">{{ __('sidebar.admin') }}</p>
    <p class="left-menu-group-mini">—</p>

    <ul class="page-sidebar-menu">
        <li>
            <a
                class="left-menu-link"
                href="{{ route('admin.dedicated_servers.index') }}"
                title="{{ __('sidebar.dedicated_servers') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-delay="200"
            >
                <i class="fas fa-hdd"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.dedicated_servers') }}</span>
            </a>
        </li>
        <li>
            <a
                class="left-menu-link"
                href="{{ route('admin.servers.index') }}"
                title="{{ __('sidebar.game_servers') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-delay="200"
            >
                <i class="fas fa-server"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.game_servers') }}</span>
            </a>
        </li>
        <li>
            <a
                class="left-menu-link"
                href="{{ route('admin.games.index') }}"
                title="{{ __('sidebar.games') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-delay="200"
            >
                <i class="fas fa-gamepad"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.games') }}</span>
            </a>
        </li>
        <li>
            <a
                class="left-menu-link"
                href="{{ route('admin.gdaemon_tasks.index') }}"
                title="{{ __('sidebar.gdaemon_tasks') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-delay="200"
            >
                <i class="fas fa-tasks"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.gdaemon_tasks') }}</span>
            </a>
        </li>
        <li>
            <a
                class="left-menu-link"
                href="{{ route('admin.users.index') }}"
                title="{{ __('sidebar.users') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-delay="200"
            >
                <i class="fas fa-users"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.users') }}</span>
            </a>
        </li>
    </ul>

    <p class="left-menu-group">{{ __('sidebar.gameap') }}</p>
    <p class="left-menu-group-mini">—</p>

    <ul class="page-sidebar-menu">
        @if(config('app.enable_experimental_features'))
            <li>
                <a
                    class="left-menu-link"
                    href="{{ route('modules') }}"
                    title="{{ __('sidebar.modules') }}"
                    data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    data-bs-delay="200"
                >
                    <i class="fas fa-puzzle-piece"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.modules') }}</span>
                </a>
            </li>
        @endif
        <li>
            <a
                class="left-menu-link"
                href="{{ route('update') }}"
                title="{{ __('sidebar.update') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-delay="200"
            >
                <i class="fas fa-sync"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.update') }}</span>
            </a>
        </li>
    </ul>
@endcan

<p class="left-menu-group">{{ __('sidebar.support') }}</p>
<p class="left-menu-group-mini">—</p>

<ul class="page-sidebar-menu">
    @can('admin roles & permissions')
        <li>
            <a
                class="left-menu-link"
                href="{{ route('report_bug') }}"
                title="{{ __('sidebar.report_bug') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                data-bs-delay="200"
            >
                <i class="fas fa-bug"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.report_bug') }}</span>
            </a>
        </li>
    @endcan
    <li>
        <a
            class="left-menu-link"
            href="{{ route('help') }}"
            title="{{ __('sidebar.help') }}"
            data-bs-toggle="tooltip"
            data-bs-placement="right"
            data-bs-delay="200"
        >
            <i class="fas fa-question"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.help') }}</span>
        </a>
    </li>
    <li>
        <a
            class="left-menu-link"
            target="_blank" href="https://forum.gameap.ru"
            title="{{ __('sidebar.forum') }}"
            data-bs-toggle="tooltip"
            data-bs-placement="right"
            data-bs-delay="200"
        >
            <i class="fas fa-comment-alt"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.forum') }}</span>
        </a>
    </li>
    <li>
        <a
            class="left-menu-link"
            target="_blank"
            href="https://docs.gameap.com"
            title="{{ __('sidebar.documentation') }}"
            data-bs-toggle="tooltip"
            data-bs-placement="right"
            data-bs-delay="200"
        >
            <i class="fab fa-wikipedia-w"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.documentation') }}<i class="fas fa-external-link"></i></span>
        </a>
    </li>
</ul>

<p class="left-menu-group md:hidden">{{ __('sidebar.profile') }}</p>

<ul class="page-sidebar-menu md:hidden">
    <li>
        <a class="left-menu-link inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-gray-900 text-white hover:bg-gray-900 navbar-btn" href="{{ route('profile') }}">
            <i class="fas fa-user"></i>&nbsp;<span class="menu-item-label">{{ Auth::user()->name }}</span>
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

<p class="left-menu-group sm:hidden md:block">&nbsp;</p>

<ul class="page-sidebar-menu sm:hidden md:block">
    <li>
        <a
            class="left-menu-link"
            href="#"
            id="left-menu-mini-btn"
            title="{{ __('sidebar.maximize') }}"
        >
            <i id="left-menu-mini-icon" class="fas fa-chevron-left"></i>&nbsp;<span class="menu-item-label">{{ __('sidebar.minimize') }}</span>
        </a>
    </li>
</ul>

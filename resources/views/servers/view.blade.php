@php($title = __('servers.title_server') )

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('servers') }}">{{ __('servers.game_servers') }}</a></li>
        <li class="breadcrumb-item">{{ $server->name }}&nbsp;&nbsp;<span class="text-muted">{{ $server->game->name }}</span></li>
    </ol>
@endsection

@section('content')
    <ul class="nav nav-tabs large mt-4">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" data-tab="main" href="#main">
                <i class="fas fa-play"></i>
                {{ __('servers.control') }}
            </a>
        </li>

        @if ($rconSupported && $server->processActive())
            @can('server-rcon', $server)
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" data-tab="rcon" href="#rcon">
                        <i class="fas fa-user-astronaut"></i>
                        RCON
                    </a>
                </li>
            @endcan
        @endif

        @can('server-files', $server)
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-tab="filemanager" href="#filemanager">
                    <i class="fa fa-folder-open"></i>
                    {{ __('servers.files') }}
                </a>
            </li>
        @endcan

        @can('server-tasks', $server)
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-tab="schedules" href="#schedules">
                    <i class="far fa-calendar-alt"></i>
                    {{ __('servers.task_scheduler') }}
                </a>
            </li>
        @endcan

        @can('server-settings', $server)
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-tab="settings" href="#settings#settings">
                    <i class="fa fa-cogs"></i>
                    {{ __('servers.settings') }}
                </a>
            </li>
        @endcan

        @can('admin roles & permissions')
            <li class="nav-item ml-auto">
                <a class="nav-link text-danger" href="{{ route('admin.servers.edit', ['server' => $server->id]) }}">
                    <i class="fa fa-hammer"></i>
                    {{ __('servers.admin') }}
                </a>
            </li>
        @endcan

    </ul>

    <div class="tab-content">
        <div class="row tab-pane container-fluid active" id="main">
            @include('servers.view_parts.main_tab', ['server' => $server])
        </div>

        @if ($rconSupported)
            <div class="row tab-pane container-fluid fade" id="rcon">
                @include('servers.view_parts.rcon_tab', [
                    'server' => $server,
                    'rconSupportedFeatures' => $rconSupportedFeatures,
                ])
            </div>
        @endif

        <div class="row tab-pane container-fluid fade" id="schedules">
            @include('servers.view_parts.schedules_tab', ['server' => $server])
        </div>

        <div class="row tab-pane container-fluid fade" id="filemanager">
            @include('servers.view_parts.filemanager_tab', ['server' => $server])
        </div>

        <div class="row tab-pane container-fluid fade" id="settings">
            @include('servers.view_parts.settings_tab', ['server' => $server])
        </div>
    </div>

@endsection

@section('footer-scripts')
    <script type="application/javascript">
        $(document).ready(function() {
            var url = document.location.toString();
            if (url.match('#')) {
                const tabLink = $('a[href="#' + url.split('#')[1] + '"]');

                if (tabLink.length === 1) {
                    tabLink.tab('show');
                    window.gameap.activeTab = tabLink.data('tab');
                }
            }

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                window.gameap.activeTab = $(e.target).data('tab');
            });

            $('a.send-rcon-command').click(function (event) {
                window.gameap.$store.dispatch('rconConsole/sendCommand', $(this).data('command'));
                event.preventDefault();
            });
        });
    </script>
@endsection

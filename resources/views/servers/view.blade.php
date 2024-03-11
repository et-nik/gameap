@php($title = __('servers.title_server') )

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('servers') }}">{{ __('servers.game_servers') }}</a></li>
        <li class="inline-block px-2 py-2 text-gray-700">{{ $server->name }}&nbsp;&nbsp;<span class="text-gray-700">{{ $server->game->name }}</span></li>
    </ol>
@endsection

@section('content')
    <ul class="flex flex-wrap list-none pl-0 mb-0 border border-t-0 border-r-0 border-l-0 border-b-1 border-gray-200 large mt-4">
        <li class="">
            <a class="inline-block py-2 px-4 no-underline active" data-bs-toggle="tab" data-tab="main" href="#main">
                <i class="fas fa-play"></i>
                {{ __('servers.control') }}
            </a>
        </li>

        @if ($rconSupported && $server->processActive())
            @can('server-rcon', $server)
                <li class="">
                    <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" data-tab="rcon" href="#rcon">
                        <i class="fas fa-user-astronaut"></i>
                        RCON
                    </a>
                </li>
            @endcan
        @endif

        @can('server-files', $server)
            <li class="">
                <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" data-tab="filemanager" href="#filemanager">
                    <i class="fa fa-folder-open"></i>
                    {{ __('servers.files') }}
                </a>
            </li>
        @endcan

        @can('server-tasks', $server)
            <li class="">
                <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" data-tab="schedules" href="#schedules">
                    <i class="far fa-calendar-alt"></i>
                    {{ __('servers.task_scheduler') }}
                </a>
            </li>
        @endcan

        @can('server-settings', $server)
            <li class="">
                <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" data-tab="settings" href="#settings">
                    <i class="fa fa-cogs"></i>
                    {{ __('servers.settings') }}
                </a>
            </li>
        @endcan

        @can('admin roles & permissions')
            <li class=" ms-auto">
                <a class="inline-block py-2 px-4 no-underline text-red-600" href="{{ route('admin.servers.edit', ['server' => $server->id]) }}">
                    <i class="fa fa-hammer"></i>
                    {{ __('servers.admin') }}
                </a>
            </li>
        @endcan

    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="main">
            @include('servers.view_parts.main_tab', ['server' => $server])
        </div>

        @if ($rconSupported)
            <div class="tab-pane opacity-0" id="rcon">
                @include('servers.view_parts.rcon_tab', [
                    'server' => $server,
                    'rconSupportedFeatures' => $rconSupportedFeatures,
                ])
            </div>
        @endif

        <div class="tab-pane opacity-0" id="schedules">
            @include('servers.view_parts.schedules_tab', ['server' => $server])
        </div>

        <div class="tab-pane opacity-0" id="filemanager">
            @include('servers.view_parts.filemanager_tab', ['server' => $server])
        </div>

        <div class="tab-pane opacity-0" id="settings">
            @include('servers.view_parts.settings_tab', ['server' => $server])
        </div>
    </div>

@endsection

@section('footer-scripts')
    <script type="application/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const url = window.location.href;
            if (url.includes('#')) {
                const tabLink = document.querySelector(`a[href="#${url.split('#')[1]}"]`);
                if (tabLink !== null) {
                    tabLink.click();
                    window.gameap.setActiveTab(tabLink.dataset.tab);
                }
            }

            document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(link) {
                link.addEventListener('shown.bs.tab', function(e) {
                    window.gameap.setActiveTab(e.target.dataset.tab);
                });
            });

            document.querySelectorAll('a.send-rcon-command').forEach(function(commandLink) {
                commandLink.addEventListener('click', function(event) {
                    window.gameap.$store.dispatch('rconConsole/sendCommand', this.dataset.command);
                    event.preventDefault();
                });
            });
        });
    </script>
@endsection

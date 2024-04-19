@php($title = __('servers.title_server') )

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("servers") }}', 'text':'{{ __("servers.game_servers") }}'},
        {'text':'{{ $server->name }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
        <n-tabs type="line" class="flex justify-between" animated>
            <n-tab-pane name="control">
                <template #tab>
                    <i class="fas fa-play mr-1"></i>
                    {{ __('servers.control') }}
                </template>

                @include('servers.view_parts.main_tab', ['server' => $server])

            </n-tab-pane>

            @if ($rconSupported && $server->processActive())
                @can('server-rcon', $server)
                    <n-tab-pane name="rcon">
                        <template #tab>
                            <i class="fas fa-user-astronaut mr-1"></i>
                            RCON
                        </template>
                    </n-tab-pane>
                @endcan

                @include('servers.view_parts.rcon_tab', [
                    'server' => $server,
                    'rconSupportedFeatures' => $rconSupportedFeatures,
                ])

            @endif

            @can('server-files', $server)
                <n-tab-pane name="files">
                    <template #tab>
                        <i class="fa fa-folder-open mr-1"></i>
                        {{ __('servers.files') }}
                    </template>

                    @include('servers.view_parts.filemanager_tab', ['server' => $server])

                </n-tab-pane>
            @endcan

            @can('server-tasks', $server)
                <n-tab-pane name="schedules">
                    <template #tab>
                        <i class="far fa-calendar-alt mr-1"></i>
                        {{ __('servers.task_scheduler') }}
                    </template>

                    @include('servers.view_parts.schedules_tab', ['server' => $server])

                </n-tab-pane>
            @endcan

            @can('server-settings', $server)
                <n-tab-pane name="settings">
                    <template #tab>
                        <i class="fa fa-cogs mr-1"></i>
                        {{ __('servers.settings') }}
                    </template>

                    @include('servers.view_parts.settings_tab', ['server' => $server])

                </n-tab-pane>
            @endcan

            @can('admin roles & permissions')
                <n-tab-pane name="admin">
                    <template #tab>
                        <div class="order-last ml-auto">
                            <i class="fa fa-hammer mr-1"></i>
                            {{ __('servers.admin') }}
                        </div>

                    </template>
                </n-tab-pane>
            @endcan
        </n-tabs>
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

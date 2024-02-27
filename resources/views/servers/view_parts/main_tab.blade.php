{{--@if ($server->processActive())--}}
    <div class="row mt-2">
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">
                    <server-status :server-id="{{ $server->id }}"></server-status>
                </div>
            </div>
        </div>

    </div>
{{--@endif--}}

<div class="row mt-2">
    @canany(['server-start', 'server-stop', 'server-restart', 'server-update'], $server)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ __('servers.commands') }}
                </div>

                <div class="card-body">
                    <div id="serverControl">
                        @can('server-start', $server)
                            @if (!$server->processActive())
                                <server-control-button
                                    command="start"
                                    server-id="{{ $server->id }}"
                                    button="btn btn-large btn-success m-1"
                                    icon="fas fa-play"
                                    text="{{ __('servers.start') }}"
                                ></server-control-button>
                            @endif
                        @endcan

                        @can('server-stop', $server)
                            @if ($server->processActive())
                                <server-control-button
                                        command="stop"
                                        server-id="{{ $server->id }}"
                                        button="btn btn-large btn-danger m-1"
                                        icon="fas fa-stop"
                                        text="{{ __('servers.stop') }}"
                                ></server-control-button>
                            @endif
                        @endcan

                        @can('server-restart', $server)
                            <server-control-button
                                    command="restart"
                                    server-id="{{ $server->id }}"
                                    button="btn btn-large btn-warning m-1"
                                    icon="fas fa-redo"
                                    text="{{ __('servers.restart') }}"
                            ></server-control-button>
                        @endcan

                        @can('server-update', $server)
                            <server-control-button
                                    command="update"
                                    server-id="{{ $server->id }}"
                                    button="btn btn-large btn-info m-1"
                                    icon="fas fa-sync"
                                    text="{{ __('servers.update') }}"
                            ></server-control-button>

                            <server-control-button
                                    command="reinstall"
                                    server-id="{{ $server->id }}"
                                    button="btn btn-large btn-dark m-1"
                                    icon="fas fa-reply-all"
                                    text="{{ __('servers.reinstall') }}"
                            ></server-control-button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    @endcanany

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                {{ __('servers.process_status') }}
            </div>
            <ul class="list-group list-group-flush">
                @if ($server->processActive())
                    <li class="list-group-item">{{ __('servers.status') }}: <span class="badge text-bg-success">{{ __('servers.active') }}</span></li>
                @else
                    <li class="list-group-item">{{ __('servers.status') }}: <span class="badge text-bg-danger">{{ __('servers.inactive') }}</span></li>
                @endif

                <li class="list-group-item">{{ __('servers.last_check') }}: {{ \Gameap\Helpers\DateHelper::convertToLocal($server->last_process_check) }}</li>
            </ul>

        </div>
    </div>
</div>

@can('server-console-view', $server)
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('servers.console') }}
                </div>
                <server-console console-hostname="{{ $server->uuid_short }}" :server-id="{{ $server->id }}" :server-active="{{ $server->processActive() ? "true" : "false" }}">
                    <div class="d-flex justify-content-center">
                        <div class="fa-3x">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </server-console>
            </div>
        </div>
    </div>
@endcan

{{--@if ($server->processActive())--}}
    <div class="flex flex-wrap  mt-2">
        <div class="md:w-full pr-4 pl-4">

            <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                <div class="flex-auto p-6">
                    <server-status :server-id="{{ $server->id }}"></server-status>
                </div>
            </div>
        </div>

    </div>
{{--@endif--}}

<div class="flex flex-wrap  mt-2">
    @canany(['server-start', 'server-stop', 'server-restart', 'server-update'], $server)
        <div class="md:w-1/2 pr-4 pl-4">
            <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                    {{ __('servers.commands') }}
                </div>

                <div class="flex-auto p-6">
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

    <div class="md:w-1/2 pr-4 pl-4">
        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
            <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                {{ __('servers.process_status') }}
            </div>
            <ul class="flex flex-col pl-0 mb-0 border rounded border-gray-300 ">
                @if ($server->processActive())
                    <li class="relative block py-3 px-6 -mb-px border border-r-0 border-l-0 border-gray-300 no-underline">{{ __('servers.status') }}: <span class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded text-bg-success">{{ __('servers.active') }}</span></li>
                @else
                    <li class="relative block py-3 px-6 -mb-px border border-r-0 border-l-0 border-gray-300 no-underline">{{ __('servers.status') }}: <span class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded text-bg-danger">{{ __('servers.inactive') }}</span></li>
                @endif

                <li class="relative block py-3 px-6 -mb-px border border-r-0 border-l-0 border-gray-300 no-underline">{{ __('servers.last_check') }}: {{ \Gameap\Helpers\DateHelper::convertToLocal($server->last_process_check) }}</li>
            </ul>

        </div>
    </div>
</div>

@can('server-console-view', $server)
    <div class="flex flex-wrap  mt-2">
        <div class="md:w-full pr-4 pl-4">
            <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                    {{ __('servers.console') }}
                </div>
                <server-console console-hostname="{{ $server->uuid_short }}" :server-id="{{ $server->id }}" :server-active="{{ $server->processActive() ? "true" : "false" }}">
                    <div class="flex justify-center">
                        <div class="fa-3x">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </server-console>
            </div>
        </div>
    </div>
@endcan

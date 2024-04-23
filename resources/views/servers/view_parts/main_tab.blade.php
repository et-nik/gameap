<div class="flex flex-wrap mt-2">
    <div class="md:w-full">
        <n-card
                class="mb-3"
        >
            <server-status :server-id="{{ $server->id }}"></server-status>
        </n-card>
    </div>
</div>

<div class="flex flex-wrap mt-2">
    @canany(['server-start', 'server-stop', 'server-restart', 'server-update'], $server)
        <div class="md:w-1/2 pr-8">
            <n-card
                    title="{{ __('servers.commands') }}"
                    class="mb-3"
                    header-class="bg-stone-100"
                    :segmented="{
                          content: true,
                          footer: 'soft'
                        }"
            >
                <div id="serverControl">
                    @can('server-start', $server)
                        @if (!$server->processActive())
                            <server-control-button
                                    command="start"
                                    server-id="{{ $server->id }}"
                                    button="m-1"
                                    button-color="green"
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
                                    button="m-1"
                                    button-color="red"
                                    icon="fas fa-stop"
                                    text="{{ __('servers.stop') }}"
                            ></server-control-button>
                        @endif
                    @endcan

                    @can('server-restart', $server)
                        <server-control-button
                                command="restart"
                                server-id="{{ $server->id }}"
                                button="m-1"
                                button-color="orange"
                                icon="fas fa-redo"
                                text="{{ __('servers.restart') }}"
                        ></server-control-button>
                    @endcan

                    @can('server-update', $server)
                        <server-control-button
                                command="update"
                                server-id="{{ $server->id }}"
                                button="m-1"
                                button-color="black"
                                icon="fas fa-sync"
                                text="{{ __('servers.update') }}"
                        ></server-control-button>

                        <server-control-button
                                command="reinstall"
                                server-id="{{ $server->id }}"
                                button="m-1"
                                button-color="black"
                                icon="fas fa-reply-all"
                                text="{{ __('servers.reinstall') }}"
                        ></server-control-button>
                    @endcan
                </div>
            </n-card>
        </div>
    @endcanany

    <div class="md:w-1/2">
        <n-card
                title="{{ __('servers.process_status') }}"
                class="mb-3"
                header-class="bg-stone-100"
                :segmented="{
                          content: true,
                          footer: 'soft'
                        }"
        >
            <ul class="flex flex-col pl-0 mb-0">
                @if ($server->processActive())
                    <li class="relative block py-3 px-6 -mb-px">{{ __('servers.status') }}: <span class="badge-green">{{ __('servers.active') }}</span></li>
                @else
                    <li class="relative block py-3 px-6 -mb-px">{{ __('servers.status') }}: <span class="badge-red">{{ __('servers.inactive') }}</span></li>
                @endif

                <li class="relative block py-3 px-6 -mb-px">{{ __('servers.last_check') }}: {{ \Gameap\Helpers\DateHelper::convertToLocal($server->last_process_check) }}</li>
            </ul>
        </n-card>
    </div>
</div>

@can('server-console-view', $server)
    <div class="flex flex-wrap mt-2">
        <div class="md:w-full">
            <n-card
                    title="{{ __('servers.console') }}"
                    class="mb-3"
                    header-class="bg-stone-100"
                    :segmented="{
                          content: true,
                          footer: 'soft'
                        }"
            >
                <server-console console-hostname="{{ $server->uuid_short }}" :server-id="{{ $server->id }}" :server-active="{{ $server->processActive() ? "true" : "false" }}">
                    <div class="flex justify-center">
                        <div class="fa-3x">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </server-console>
            </n-card>
        </div>
    </div>
@endcan

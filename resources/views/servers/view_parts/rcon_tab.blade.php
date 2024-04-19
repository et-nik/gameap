@php
/**
* @var $server \Gameap\Models\Server
* @var $rconSupportedFeatures array
**/
@endphp

@php($playersGrid = Gate::check('server-rcon-console', $server)
            ? 'col-lg-6'
            : 'col-lg-12'
)

<div class="flex flex-wrap mt-2">
    @if (!empty($rconSupportedFeatures['playersManage']))
        @can('server-rcon-players', $server)
            <div class="{{ $playersGrid }}">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                        <h3>{{ __('rcon.players_manage') }}</h3>
                    </div>

                    <div class="flex-auto p-6">
                        <rcon-players v-if="activeTab === 'rcon'" :server-id="{{ $server->id }}">
                            <div class="flex justify-center">
                                <div class="fa-3x">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>
                        </rcon-players>
                    </div>
                </div>
            </div>
        @endcan
    @endif

    @can('server-rcon-console', $server)
        <div class="lg:w-1/2">
            <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                    <h3>{{ __('rcon.console') }}</h3>
                </div>

                <div class="flex-auto p-6">
                    <rcon-console v-if="activeTab === 'rcon'" :server-id="{{ $server->id }}">
                        <div class="flex justify-center">
                            <div class="fa-3x">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>
                    </rcon-console>
                </div>

                @if (!empty($server->gameMod->fast_rcon))
                    <div class="py-3 px-6 bg-gray-200 border-t-1 border-gray-300">
                        @foreach ($server->gameMod->fast_rcon as $rconCommand)
                            <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline bg-teal-500 text-white hover:bg-teal-600 m-1 send-rcon-command" data-command="{{ $rconCommand['command'] }}" href="#">{{ $rconCommand['info'] }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endcan
</div>

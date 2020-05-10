<div class="row mt-2">
    @if (!empty($rconSupportedFeatures['playersManage']))
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('rcon.players_manage') }}</h3>
                </div>

                <div class="card-body">
                    <rcon-players v-if="activeTab === 'rcon'" :server-id="{{ $server->id }}">
                        <div class="d-flex justify-content-center">
                            <div class="fa-3x">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </div>
                    </rcon-players>
                </div>
            </div>
        </div>
    @endif

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3>{{ __('rcon.console') }}</h3>
            </div>

            <div class="card-body">
                <rcon-console v-if="activeTab === 'rcon'" :server-id="{{ $server->id }}">
                    <div class="d-flex justify-content-center">
                        <div class="fa-3x">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </rcon-console>
            </div>

            @if (!empty($server->gameMod->fast_rcon))
                <div class="card-footer">
                    @foreach ($server->gameMod->fast_rcon as $rconCommand)
                        <a class="btn btn-info m-1 send-rcon-command" data-command="{{ $rconCommand['command'] }}" href="#">{{ $rconCommand['info'] }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

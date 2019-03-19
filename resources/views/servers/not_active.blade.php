@php($title = __('servers.title_server') )

@extends('layouts.main')

@section('content')
    @if ($server->installed === $server::NOT_INSTALLED)
        <div class="alert alert-danger">
            <p>{{ __('servers.server_not_installed_msg') }}</p>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-large btn-info" href="#" @click="updateServer({{ $server->id }})">
                            <span class="fas fa-sync"></span>&nbsp;{{ __('servers.update') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

    @elseif(!$server->installed === $server::INSTALLATION_PROCESS)
        <div class="alert alert-warning">
            <p>{{ __('servers.server_installation_process_msg') }}</p>

            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
            </div>
        </div>
    @elseif(!$server->enabled)
        <div class="alert alert-danger">
            <p>{{ __('servers.server_disabled_msg') }}</p>
        </div>
    @elseif($server->blocked)
        <div class="alert alert-danger">
            <p>{{ __('servers.server_blocked_msg') }}</p>
        </div>
    @endif
@endsection
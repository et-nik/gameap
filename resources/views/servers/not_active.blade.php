@php
/**
 * @var $server \Gameap\Models\Server
 * @var $installationTaskExists bool
 *
*/
@endphp

@php($title = __('servers.title_server') )

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('servers') }}">{{ __('servers.game_servers') }}</a></li>
    </ol>
@endsection

@section('content')
    @if ($server->installed === $server::NOT_INSTALLED)
        <div class="alert alert-danger">
            <p>{{ __('servers.not_installed_msg') }}</p>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="serverControl">
                            <a class="btn btn-large btn-info" href="#" @click="updateServer({{ $server->id }})">
                                <span class="fas fa-download"></span>&nbsp;{{ __('servers.install') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($server->installed === $server::INSTALLATION_PROCESS)
        <div class="alert alert-warning">
            <p>{{ __('servers.installation_process_msg') }}</p>

            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
            </div>
        </div>

        @can('admin roles & permissions')
            @if(!$installationTaskExists)
                <div class="alert alert-warning">
                    {!! __('servers.d_installation_is_stuck', ['link' => route('admin.servers.edit', $server->id)]) !!}
                </div>
            @endif
        @endcan
    @elseif(!$server->enabled)
        <div class="alert alert-danger">
            <p>{{ __('servers.disabled_msg') }}</p>
        </div>
    @elseif($server->blocked)
        <div class="alert alert-danger">
            <p>{{ __('servers.blocked_msg') }}</p>
        </div>
    @endif
@endsection

@php
/**
 * @var $server \Gameap\Models\Server
 * @var $installationTaskExists bool
 *
*/
@endphp

@php($title = __('servers.title_server') )

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('servers') }}">{{ __('servers.game_servers') }}</a></li>
    </ol>
@endsection

@section('content')
    @if ($server->installed === $server::NOT_INSTALLED)
        <div class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800">
            <p>{{ __('servers.not_installed_msg') }}</p>
        </div>

        <div class="flex flex-wrap  mt-2">
            <div class="md:w-full pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="flex-auto p-6">
                        <div id="serverControl">
                            <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline btn-large bg-teal-500 text-white hover:bg-teal-600" href="#" @click="updateServer({{ $server->id }})">
                                <span class="fas fa-download"></span>&nbsp;{{ __('servers.install') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($server->installed === $server::INSTALLATION_PROCESS)
        <div class="relative px-3 py-3 mb-4 border rounded bg-orange-200 border-orange-300 text-orange-800">
            <p>{{ __('servers.installation_process_msg') }}</p>

            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
            </div>
        </div>

        @can('admin roles & permissions')
            @if(!$installationTaskExists)
                <div class="relative px-3 py-3 mb-4 border rounded bg-orange-200 border-orange-300 text-orange-800">
                    {!! __('servers.d_installation_is_stuck', ['link' => route('admin.servers.edit', $server->id)]) !!}
                </div>
            @endif
        @endcan
    @elseif(!$server->enabled)
        <div class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800">
            <p>{{ __('servers.disabled_msg') }}</p>
        </div>
    @elseif($server->blocked)
        <div class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800">
            <p>{{ __('servers.blocked_msg') }}</p>
        </div>
    @endif
@endsection

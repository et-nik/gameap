@php($title = __('dedicated_servers.title_view'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('admin.dedicated_servers.index') }}">Dedicated servers</a></li>
        <li class="inline-block px-2 py-2 text-gray-700 active">View</li>
    </ol>
@endsection

@section('content')
    <a class='inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-orange-400 text-black hover:bg-orange-500 me-1' href="{{ route('admin.dedicated_servers.download_logs', $dedicatedServer->id) }}">
        <i class="fas fa-download"></i> {{ __('dedicated_servers.download_logs') }}
    </a>

    <a class='inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-green-500 text-white hover:bg-green-600' href="{{ route('admin.dedicated_servers.download_certificates', $dedicatedServer->id) }}">
        <i class="fas fa-download"></i> {{ __('dedicated_servers.download_certificates') }}
    </a>

    <hr>

    <div class="flex flex-wrap ">
        <div class="md:w-full pr-4 pl-4">
            <table class="w-full max-w-full mb-4 bg-transparent table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{!! $dedicatedServer->id !!}</td>
                    </tr>
                    <tr>
                        <th>{{ __('dedicated_servers.name') }}</th>
                        <td>{!! $dedicatedServer->name !!}</td>
                    </tr>
                    <tr>
                        <th>{{ __('dedicated_servers.gdaemon_api_key') }}</th>
                        <td>{!! $dedicatedServer->gdaemon_api_key !!}</td>
                    </tr>

                    <tr>
                        <th>{{ __('dedicated_servers.gdaemon_version') }}</th>
                        <td>
                            @if(!empty($gdaemonVersion))
                                {{ $gdaemonVersion['version'] }} ({{ $gdaemonVersion['compile_date'] }})
                            @else
                                {{ __('dedicated_servers.gdaemon_empty_info') }}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>{{ __('dedicated_servers.gdaemon_uptime') }}</th>
                        <td>
                            @if(!empty($baseInfo))
                                {{ $baseInfo['uptime'] }}
                            @else
                                {{ __('dedicated_servers.gdaemon_empty_info') }}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>{{ __('dedicated_servers.gdaemon_online_servers_count') }}</th>
                        <td>
                            @if(!empty($baseInfo))
                                {{ $baseInfo['online_servers_count'] }}
                            @else
                                {{ __('dedicated_servers.gdaemon_empty_info') }}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>{{ __('dedicated_servers.gdaemon_working_tasks_count') }}</th>
                        <td>
                            @if(!empty($baseInfo))
                                {{ $baseInfo['working_tasks_count'] }}
                            @else
                                {{ __('dedicated_servers.gdaemon_empty_info') }}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>{{ __('dedicated_servers.gdaemon_waiting_tasks_count') }}</th>
                        <td>
                            @if(!empty($baseInfo))
                                {{ $baseInfo['waiting_tasks_count'] }}
                            @else
                                {{ __('dedicated_servers.gdaemon_empty_info') }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{--TODO: Game servers info here!--}}

    {{--TODO: Stats here!--}}

@endsection

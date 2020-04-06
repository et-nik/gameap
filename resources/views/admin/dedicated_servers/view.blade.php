@php($title = __('dedicated_servers.title_view'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.dedicated_servers.index') }}">Dedicated servers</a></li>
        <li class="breadcrumb-item active">View</li>
    </ol>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered detail-view">
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

@php($title = __('dedicated_servers.title_view'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.dedicated_servers.index") }}', 'text':'{{ __("dedicated_servers.dedicated_servers") }}'},
        {'text':'{{ __("dedicated_servers.view") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    <div class="page-list-menu mb-3">
        <a class='inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline bg-orange-400 text-black hover:bg-orange-500 me-1' href="{{ route('admin.dedicated_servers.download_logs', $dedicatedServer->id) }}">
            <i class="fas fa-download"></i> {{ __('dedicated_servers.download_logs') }}
        </a>

        <a class='inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline bg-lime-500 text-white hover:bg-lime-600' href="{{ route('admin.dedicated_servers.download_certificates', $dedicatedServer->id) }}">
            <i class="fas fa-download"></i> {{ __('dedicated_servers.download_certificates') }}
        </a>
    </div>

    <div class="flex flex-wrap ">
        <div class="md:w-full pr-8">
            <key-value-table
                :items='{
                    "ID": "{{ $dedicatedServer->id }}",
                    "{{ __('dedicated_servers.name') }}": "{{ $dedicatedServer->name }}",
                    "{{ __('dedicated_servers.gdaemon_api_key') }}": "{{ $dedicatedServer->gdaemon_api_key }}",
                    "{{ __('dedicated_servers.gdaemon_version') }}": "{{ !empty($gdaemonVersion) ? $gdaemonVersion['version'] . ' (' . $gdaemonVersion['compile_date'] . ')' : __('dedicated_servers.gdaemon_empty_info') }}",
                    "{{ __('dedicated_servers.gdaemon_uptime') }}": "{{ !empty($baseInfo) ? $baseInfo['uptime'] : __('dedicated_servers.gdaemon_empty_info') }}",
                    "{{ __('dedicated_servers.gdaemon_online_servers_count') }}": "{{ !empty($baseInfo) ? $baseInfo['online_servers_count'] : __('dedicated_servers.gdaemon_empty_info') }}",
                    "{{ __('dedicated_servers.gdaemon_working_tasks_count') }}": "{{ !empty($baseInfo) ? $baseInfo['working_tasks_count'] : __('dedicated_servers.gdaemon_empty_info') }}",
                    "{{ __('dedicated_servers.gdaemon_waiting_tasks_count') }}": "{{ !empty($baseInfo) ? $baseInfo['waiting_tasks_count'] : __('dedicated_servers.gdaemon_empty_info') }}",
                }'
            ></key-value-table>
        </div>
    </div>

    {{--TODO: Game servers info here!--}}

    {{--TODO: Stats here!--}}

@endsection

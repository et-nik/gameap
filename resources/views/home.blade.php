@php
/**
 * @var $modules \Gameap\Models\Modules\LaravelModule[]
**/
@endphp

@extends('layouts.main')

@section('content')

    <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mb-2">
        <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
            {{ __('home.main') }}
        </div>
        <div class="flex-auto p-6">
            <div class="flex flex-wrap ">
                <div class="flex flex-no-wrap">
                    <div class="p-2 mb-3 text-center menu-item">
                        <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded  no-underline d-grid gap-3 py-3 px-4 leading-tight text-xl text-gray-900 border-gray-900 hover:bg-gray-900 hover:text-white bg-white hover:bg-gray-900 rounded" href="{{ route('servers') }}">
                            <i class="fas fa-server fa-5x m-1"></i>
                            <h5>{{ __('home.servers_list') }}</h5>
                        </a>
                    </div>
                </div>

                @foreach ($modules as $module)
                    @if (!empty($module->mainRoute))
                        <div class="flex flex-no-wrap">
                            <div class="p-2 mb-3 text-center menu-item">
                                <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded  no-underline d-grid gap-3 py-3 px-4 leading-tight text-xl text-gray-900 border-gray-900 hover:bg-gray-900 hover:text-white bg-white hover:bg-gray-900 rounded" href="{{ $module->mainRoute }}">

                                    @if (!empty($module->icon))
                                        {!! $module->icon !!}
                                    @else
                                        <i class="fas fa-server fa-5x m-1"></i>
                                    @endif

                                    <h5>{{ $module->name }}</h5>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    </div>

    @can('admin roles & permissions')
        @if (!empty($problems))
            <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mb-2">
                <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                    <i class="fas fa-exclamation-triangle"></i> {{ __('home.problems') }}
                </div>
                <div class="flex-auto p-6">
                    @foreach ($problems as $problem)
                        <n-alert title="{{ __('main.error') }}" type="error">
                            {{ $problem }}
                        </n-alert>
                    @endforeach
                </div>
            </div>
        @endif
    @endcan

    <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mb-2">
        <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
            {{ __('home.information') }}
        </div>
        <div class="flex-auto p-6">
            <div class="md:w-full pr-4 pl-4">
                <div class="flex flex-wrap ">
                    <div class="md:w-1/3 pr-4 pl-4"><i class="fas fa-info-circle"></i> {{ __('home.your_version') }}:
                        <span class="whitespace-nowrap">{{ Config::get('constants.AP_VERSION') }}</span>
                    </div>

                    <div class="md:w-1/3 pr-4 pl-4">
                        {{ __('home.latest_stable') }}: <span class="whitespace-nowrap">{{ $latestVersion }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap ">
        <div class="md:w-1/3 pr-4 pl-4">
            <a href="{{ route('help') }}" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded  no-underline d-grid gap-1 py-3 px-4 leading-tight text-xl bg-orange-400 text-black hover:bg-orange-500 rounded">
                <i class="fas fa-hands-helping"></i> {{ __('home.get_help') }}
            </a>
        </div>

        <div class="md:w-1/3 pr-4 pl-4">
            <a target="_blank" href="https://docs.gameap.com" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded  no-underline d-grid gap-1 py-3 px-4 leading-tight text-xl bg-teal-500 text-white hover:bg-teal-600 rounded">
                <i class="fas fa-book"></i> {{ __('home.documentation') }}
            </a>
        </div>

        <div class="md:w-1/3 pr-4 pl-4">
            <a href="{{ route('report_bug') }}" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded  no-underline d-grid gap-1 py-3 px-4 leading-tight text-xl bg-red-600 text-white hover:bg-red-700 rounded">
                <i class="fas fa-bug"></i> {{ __('home.report_bug') }}
            </a>
        </div>
    </div>

@endsection

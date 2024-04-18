@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'text':'{{ __("home.update") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mb-2">
        <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
            {{ __('home.update') }}
        </div>
        <div class="flex-auto p-6">
            <div class="md:w-full pr-4 pl-4">
                <div class="flex flex-wrap ">

                    <div class="md:w-full pr-4 pl-4">
                        @php ($versionCompare = version_compare(Config::get('constants.AP_VERSION'), $latestVersion))

                        @if($versionCompare == -1)
                            <div class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800">
                                {{ __('home.old_version') }}
                            </div>
                        @elseif ($versionCompare == 0)
                            <div class="relative px-3 py-3 mb-4 border rounded bg-green-200 border-green-300 text-green-800">
                                {{ __('home.actual_version') }}
                            </div>
                        @else
                            <div class="relative px-3 py-3 mb-4 border rounded bg-orange-200 border-orange-300 text-orange-800">
                                {{ __('home.dev_version') }}
                            </div>
                        @endif
                    </div>

                    <div class="md:w-full pr-4 pl-4">{{ __('home.latest_stable') }}: {{ $latestVersion }}</div>
                    <div class="md:w-full pr-4 pl-4">{{ __('home.your_version') }}: {{ Config::get('constants.AP_VERSION') }}</div>
                </div>

                <div class="flex flex-wrap  mt-4">
                    <div class="md:w-1/2 pr-4 pl-4"><i class="fas fa-book"></i> {{ __('home.documentation') }}: <a target="_blank" href="http://docs.gameap.com/en/">https://docs.gameap.com</a></div>
                </div>
            </div>
        </div>
    </div>
@endsection

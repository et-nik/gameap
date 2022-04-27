@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item">{{ __('home.update') }}</li>
    </ol>
@endsection

@section('content')
    <div class="card mb-2">
        <div class="card-header">
            {{ __('home.update') }}
        </div>
        <div class="card-body">
            <div class="col-12">
                <div class="row">

                    <div class="col-12">
                        @php ($versionCompare = version_compare(Config::get('constants.AP_VERSION'), $latestVersion))

                        @if($versionCompare == -1)
                            <div class="alert alert-danger">
                                {{ __('home.old_version') }}
                            </div>
                        @elseif ($versionCompare == 0)
                            <div class="alert alert-success">
                                {{ __('home.actual_version') }}
                            </div>
                        @else
                            <div class="alert alert-warning">
                                {{ __('home.dev_version') }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="col-12">{{ __('home.latest_stable') }}: {{ $latestVersion }}</div>
                    <div class="col-12">{{ __('home.your_version') }}: {{ Config::get('constants.AP_VERSION') }}</div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-6"><i class="fas fa-book"></i> {{ __('home.documentation') }}: <a target="_blank" href="http://docs.gameap.ru/en/">https://docs.gameap.ru</a></div>
                </div>
            </div>
        </div>
    </div>
@endsection
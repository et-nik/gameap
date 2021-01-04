@php($title = __('modules.title'))

@extends('layouts.main')

@section('content')
    @include('components.form.errors_block')

    <a class='btn btn-success' href="{{ route('modules.migrate') }}"><i class="fas fa-redo"></i>&nbsp;{{ __('modules.migrate') }}</a>
    <hr>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('modules') }}">{{ __('modules.installed') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('modules.marketplace') }}">{{ __('modules.marketplace') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="row tab-pane container-fluid active" id="main">
            <div class="row">
                <div class="col-md-12">
                    @include('components.grid', [
                        'modelsList' => $modules,
                        'labels' => [__('modules.name'), __('modules.description'), __('modules.tags')],
                        'attributes' => ['name', 'description', 'tags'],
                        'destroyRoute' => 'modules.destroy',
                    ])
                </div>
            </div>
        </div>
    </div>


@endsection

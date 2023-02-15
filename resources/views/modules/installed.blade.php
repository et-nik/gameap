@php
/**
* @var $modules \Gameap\Models\Modules\LaravelModule[]
**/
@endphp

@php($title = __('modules.title'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">{{ __('modules.modules') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    <div class="page-list-menu mb-3">
        @include('modules.migrate_button')
    </div>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('modules') }}">{{ __('modules.installed') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('modules.marketplace') }}">{{ __('modules.marketplace') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="main">
            <div class="row">
                <div class="col-md-12">
                    @include('components.grid', [
                        'modelsList' => $modules,
                        'labels' => [__('modules.name'), __('modules.description'), __('modules.tags')],
                        'attributes' => ['name', 'description', 'tags'],
                        'destroyRoute' => 'modules.destroy',
                        'customActionsBefore' => static function(string $modelKey, \Gameap\Models\Modules\LaravelModule $model) {
                            $buttons = '';

                            if ($model->isEnabled) {
                                $buttons .= Form::submitButton([
                                    'id'    => 'enable-module-' . $modelKey,
                                    'route' => route('modules.disable'),
                                    'data'  => ['module' => $modelKey],
                                    'icon'  => '<i class="fas fa-times-circle"></i>',
                                    'text'  => __('modules.disable'),
                                    'class' => 'btn btn-dark btn-sm'
                                ]);
                            } else {
                                $buttons .= Form::submitButton([
                                    'id'    => 'enable-module-' . $modelKey,
                                    'route' => route('modules.enable'),
                                    'data'  => ['module' => $modelKey],
                                    'icon'  => '<i class="fas fa-check-circle"></i>',
                                    'text'  => __('modules.enable'),
                                    'class' => 'btn btn-success btn-sm'
                                ]);
                            }

                            return $buttons;
                        }
                    ])
                </div>
            </div>
        </div>
    </div>


@endsection

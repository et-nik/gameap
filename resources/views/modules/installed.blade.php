@php
/**
* @var $modules \Gameap\Models\Modules\LaravelModule[]
**/
@endphp

@php($title = __('modules.title'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'text':'{{ __("modules.modules") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    @include('components.form.errors_block')

    <div class="page-list-menu mb-3">
        @include('modules.migrate_button')
    </div>

    <ul class="flex flex-wrap list-none pl-0 mb-0 border border-t-0 border-r-0 border-l-0 border-b-1 border-gray-200">
        <li class="-mb-px">
            <a class="inline-block py-2 px-4 no-underline border border-b-0 mx-1 rounded rounded-t active" href="{{ route('modules') }}">{{ __('modules.installed') }}</a>
        </li>
        <li class="-mb-px">
            <a class="inline-block py-2 px-4 no-underline border border-b-0 mx-1 rounded rounded-t" href="{{ route('modules.marketplace') }}">{{ __('modules.marketplace') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="main">
            <div class="flex flex-wrap ">
                <div class="md:w-full pr-4 pl-4">
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

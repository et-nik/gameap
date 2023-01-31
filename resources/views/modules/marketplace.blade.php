@php
/**
* @var $modules \Gameap\Models\Modules\MarketplaceModule[]
* @var $installedModules array
**/
@endphp

@php($title = __('modules.marketplace'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="/modules">{{ __('modules.modules') }}</a></li>
        <li class="breadcrumb-item active">{{ __('modules.marketplace') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    <div class="page-list-menu mb-3">
        @include('modules.migrate_button')
    </div>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('modules') }}">{{ __('modules.installed') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('modules.marketplace') }}">{{ __('modules.marketplace') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="main">
            <div class="row">
                <div class="col-md-12">
                    @include('components.grid', [
                        'modelsList' => $modules,
                        'labels' => [__('modules.name'), __('modules.description'), __('modules.tags')],
                        'attributes' => [
                            'name',
                            'summary',
                            [
                                'lambda',
                                static function(\Gameap\Models\Modules\MarketplaceModule $module) {
                                    return implode(', ', $module->tags);
                                }
                            ],
                        ],
                        'customActionsBefore' => static function(string $modelKey, \Gameap\Models\Modules\MarketplaceModule $module) use ($installedModules) {
                            $buttons = '';

                            if (!array_key_exists($module->id, $installedModules)) {
                                // Install Button
                                $buttons .= Form::submitButton([
                                    'id'    => 'install-module-' . $module->id,
                                    'route' => route('modules.install'),
                                    'data'  => ['module' => $module->id, 'version' => $module->latestVersion],
                                    'icon'  => '<i class="fas fa-download"></i>',
                                    'text'  => __('modules.install'),
                                    'class' => 'btn btn-success btn-sm'
                                ]);
                            } else if (version_compare($module->latestVersion, $installedModules[$module->id], '>')) {
                                // Update Button
                                $buttons .= Form::submitButton([
                                    'id'    => 'update-module-' . $module->id,
                                    'route' => route('modules.install'),
                                    'data'  => ['module' => $module->id, 'version' => $module->latestVersion],
                                    'icon'  => '<i class="far fa-arrow-alt-circle-up"></i>',
                                    'text'  => __('modules.update'),
                                    'class' => 'btn btn-warning btn-sm'
                                ]);
                            } else {
                                $buttons .= '<a class="btn btn-small btn-light btn-sm disabled" title="' . __('modules.already_installed') . '" href="#">';
                                $buttons .= '<i class="fas fa-download"></i><span class="d-none d-xl-inline">&nbsp;' . __('modules.already_installed') . '</span>';
                                $buttons .= '</a>';
                            }

                            return $buttons;
                        }
                    ])
                </div>
            </div>
        </div>
    </div>


@endsection

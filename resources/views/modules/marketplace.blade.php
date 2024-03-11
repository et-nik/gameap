@php
/**
* @var $modules \Gameap\Models\Modules\MarketplaceModule[]
* @var $installedModules array
**/
@endphp

@php($title = __('modules.marketplace'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/modules">{{ __('modules.modules') }}</a></li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ __('modules.marketplace') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    <div class="page-list-menu mb-3">
        @include('modules.migrate_button')
    </div>

    <ul class="flex flex-wrap list-none pl-0 mb-0 border border-t-0 border-r-0 border-l-0 border-b-1 border-gray-200">
        <li class="">
            <a class="inline-block py-2 px-4 no-underline" href="{{ route('modules') }}">{{ __('modules.installed') }}</a>
        </li>
        <li class="">
            <a class="inline-block py-2 px-4 no-underline active" href="{{ route('modules.marketplace') }}">{{ __('modules.marketplace') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="main">
            <div class="flex flex-wrap ">
                <div class="md:w-full pr-4 pl-4">
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
                                $buttons .= '<a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded  no-underline btn-small bg-gray-100 text-gray-800 hover:bg-gray-200 py-1 px-2 leading-tight text-xs  opacity-75" title="' . __('modules.already_installed') . '" href="#">';
                                $buttons .= '<i class="fas fa-download"></i><span class="hidden xl:inline">&nbsp;' . __('modules.already_installed') . '</span>';
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

{{--
/**
* @var $modules \Gameap\Models\Module[]
* @var $installedModules array
**/
--}}

@php($title = __('modules.marketplace'))

@extends('layouts.main')

@section('content')
    @include('components.form.errors_block')

    @include('modules.migrate_button')
    <hr>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('modules') }}">{{ __('modules.installed') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('modules.marketplace') }}">{{ __('modules.marketplace') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="row tab-pane container-fluid active" id="main">
            <div class="row">
                <div class="col-md-12">
                    @include('components.grid', [
                        'modelsList' => $modules,
                        'labels' => [__('modules.name'), __('modules.description'), __('modules.tags'), __('main.actions')],
                        'attributes' => [
                            'name',
                            'summary',
                            [
                                'lambda',
                                static function(\Gameap\Models\Modules\MarketplaceModule $module) {
                                    return implode(', ', $module->tags);
                                }
                            ],
                            [
                                'lambda',
                                static function(\Gameap\Models\Modules\MarketplaceModule $module) use ($installedModules) {
                                    $buttons = '';

                                    // Install Button
                                    if (!array_key_exists($module->id, $installedModules)) {
                                        $buttons .= Form::open([
                                            'url' => route('modules.install'),
                                            'style'=>'display:inline']
                                        );
                                        $buttons .= Form::hidden('_method', 'POST');
                                        $buttons .= Form::hidden('module', $module->id);
                                        $buttons .= Form::hidden('version', $module->latestVersion);
                                        $buttons .= Form::button(
                                            '<i class="fas fa-download"></i><span class="d-none d-xl-inline">&nbsp;' . __('modules.install') . '</span>',
                                            [
                                                'class' => 'btn btn-success btn-sm',
                                                'v-on:click' => 'confirmAction($event, \'' . __('main.confirm_message'). '\')',
                                                'type' => 'submit',
                                            ]
                                        );

                                        $buttons .= Form::close();
                                    } else {
                                        $buttons .= '<a class="btn btn-small btn-light btn-sm disabled" title="' . __('modules.already_installed') . '" href="#">';
                                        $buttons .= '<i class="fas fa-download"></i><span class="d-none d-xl-inline">&nbsp;' . __('modules.already_installed') . '</span>';
                                        $buttons .= '</a>';
                                    }

                                    return $buttons;
                                }
                            ],
                        ],
                    ])
                </div>
            </div>
        </div>
    </div>


@endsection

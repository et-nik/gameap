@php($title = __('games.title_games_list'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'text':'{{ __("games.games") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    <div class="page-list-menu mb-3">
        <g-button class="mr-1" color="green" link="{{ route('admin.games.create') }}">
            <i class="fa fa-plus-square"></i>&nbsp;{{ __('games.add') }}
        </g-button>

        <g-button class="mr-1" color="orange" link="{{ route('admin.game_mods.create', ['game' => null]) }}">
            <i class="fa fa-cat"></i>&nbsp;{{ __('games.add_mod') }}
        </g-button>

        {{ Form::open(['method' => 'PATCH', 'url' => route('admin.games.upgrade'), 'style'=>'display:inline']) }}
        {{ Form::button( '<i class="fas fa-sync"></i>&nbsp;' . __('games.upgrade'),
        [
            'class' => 'inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline btn-large bg-stone-700 text-white hover:bg-stone-800',
            'v-on:click' => 'confirmAction($event, \'' . __('games.d_upgrade_confirm') . '\')',
            'type' => 'submit'
        ]
        ) }}
        {{ Form::close() }}
    </div>

    @include('components.grid', [
        'modelsList' => $games,
        'labels' => [__('games.name'), __('games.code'), __('games.engine'), __('games.mods')],
        'attributes' => [
            'name',
            'code',
            'engine',
            ['lambda', function($gameModel) {
                $modLinks = '';
                foreach ($gameModel->mods as $mod) {

                    $destroyButton = Form::open(array('url' => route('admin.game_mods.destroy', ['game_mod' => $mod->getKey()]), 'style'=>'display:inline'));
                    $destroyButton .= Form::hidden('_method', 'DELETE');
                    $destroyButton .= Form::button('<span class="ml-4 text-red-500 fa fa-times"></span>', [
                        'class' => 'btn btn-link btn-sm text-danger',
                        'v-on:click' => 'confirmAction($event, \'' . __('main.confirm_message'). '\')',
                        'type' => 'submit',
                    ]);

                    $destroyButton .= Form::close();

                    $modLinks .= "<li>
                        <a class=\"link\" href=\"" . route('admin.game_mods.edit', ['game_mod' => $mod->id]) . "\">{$mod->name}</a>
                        {$destroyButton}
                    </li>";
                }

                if (empty($modLinks)) {
                    return "<a class=\"inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded no-underline btn-small bg-orange-500 text-white hover:bg-orange-600 py-1.5 px-2 leading-tight text-xs btn-edit\" href=\"" . route('admin.game_mods.create', ['game' => $gameModel->getKey()]) . "\">
                        <span class=\"fa fa-cat\"></span>&nbsp;" . __('games.add_first_mod') . "
                    </a>";
                } else {
                    return "<ul class=\"max-w-md space-y-1 list-none list-inside\">{$modLinks}</ul>";
                }
            }]
        ],
        'editRoute' => 'admin.games.edit',
        'destroyRoute' => 'admin.games.destroy',
    ])

    {!! $games->links() !!}
@endsection

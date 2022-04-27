@php($title = __('games.title_games_list'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">{{ __('games.games') }}</li>
    </ol>
@endsection

@section('content')
    <div class="page-list-menu mb-3">
        <a class='btn btn-success' href="{{ route('admin.games.create') }}">
            <i class="fa fa-plus-square"></i>&nbsp;{{ __('games.add') }}
        </a>

        <a class="btn btn-large btn-warning" href="{{ route('admin.game_mods.create', ['game' => null]) }}">
            <i class="fa fa-cat"></i>&nbsp;{{ __('games.add_mod') }}
        </a>

        {{ Form::open(['method' => 'PATCH', 'url' => route('admin.games.upgrade'), 'style'=>'display:inline']) }}
        {{ Form::button( '<i class="fas fa-sync"></i>&nbsp;' . __('games.upgrade'),
        [
            'class' => 'btn btn-dark',
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
                    $destroyButton .= Form::button('<span class="fa fa-times"></span>', [
                        'class' => 'btn btn-link btn-sm text-danger',
                        'v-on:click' => 'confirmAction($event, \'' . __('main.confirm_message'). '\')',
                        'type' => 'submit',
                    ]);

                    $destroyButton .= Form::close();

                    $modLinks .= "<li>
                        <a href=\"" . route('admin.game_mods.edit', ['game_mod' => $mod->id]) . "\">{$mod->name}</a>
                        {$destroyButton}
                    </li>";
                }

                if (empty($modLinks)) {
                    return "<a class=\"btn btn-sm btn-warning\" href=\"" . route('admin.game_mods.create', ['game' => $gameModel->getKey()]) . "\">
                        <span class=\"fa fa-cat\"></span>&nbsp;" . __('games.add_first_mod') . "
                    </a>";
                } else {
                    return "<ul class=\"list-unstyled\">{$modLinks}</ul>";
                }
            }]
        ],
        // 'viewRoute' => 'admin.games.show',
        'editRoute' => 'admin.games.edit',
        'destroyRoute' => 'admin.games.destroy',
    ])

    {!! $games->links() !!}
@endsection
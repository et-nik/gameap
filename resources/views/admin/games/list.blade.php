@php($title = __('games.title_games_list'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">{{ __('games.games') }}</li>
    </ol>
@endsection

@section('content')
    <div class="mb-2">
        <a class='btn btn-success' href="{{ route('admin.games.create') }}">
            <span class="fa fa-plus-square"></span>&nbsp;{{ __('games.add') }}
        </a>

        <a class="btn btn-large btn-warning" href="{{ route('admin.game_mods.create', ['game' => null]) }}">
            <span class="fa fa-cat"></span>&nbsp;{{ __('games.add_mod') }}
        </a>
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

                    $destroyButton = Form::open(array('url' => route('admin.game_mods.destroy', ['gameMod' => $mod->getKey()]), 'style'=>'display:inline'));
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
        'viewRoute' => 'admin.games.show',
        'editRoute' => 'admin.games.edit',
        'destroyRoute' => 'admin.games.destroy',
    ])

    {!! $games->links() !!}
@endsection
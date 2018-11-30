@php($title = "Edit Game")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.games.index') }}">Games</a></li>
        <li class="breadcrumb-item active">Edit Game</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    <div class="mb-1">
        <a class="btn btn-large btn-success" href="{{ route('admin.game_mods.create', ['game' => $game->code]) }}">
            <span class="fa fa-cat"></span>&nbsp;Create Mod
        </a>
    </div>

    {!! Form::model($game, ['method' => 'PATCH','route' => ['admin.games.update', $game->code]]) !!}

    <div class="row mt-2 mb-2">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    {{ Form::bsText('code', null, null, ['disabled']) }}
                    {{ Form::bsText('start_code') }}
                    {{ Form::bsText('name') }}

                    {{ Form::bsText('engine') }}
                    {{ Form::bsText('engine_version') }}
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    Mods
                </div>
                <div class="card-body">

                    <ul class="list-group list-group-flush">
                        @foreach ($game->mods as $mod)
                            <li class="list-group-item"><a href="{{ route('admin.game_mods.edit', ['game_mod' => $mod->id]) }}">{{ $mod->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
    {!! Form::close() !!}
@endsection

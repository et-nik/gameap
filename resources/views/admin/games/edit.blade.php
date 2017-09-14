@php($title = "Edit Game")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li><a href="/">GameAP</a></li>
        <li><a href="{{ route('admin.games.index') }}">Games</a></li>
        <li>Edit Game</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::model($game, ['method' => 'PATCH','route' => ['admin.games.update', $game->code]]) !!}
        <div class="col-md-6">
            {{ Form::bsText('code', null, null, ['disabled']) }}
            {{ Form::bsText('start_code') }}
            {{ Form::bsText('name') }}
        </div>

        <div class="col-md-6">
            {{ Form::bsText('engine') }}
            {{ Form::bsText('engine_version') }}
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
            </div>
        </div>
    {!! Form::close() !!}
@endsection

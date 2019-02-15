@php($title = __('games.title_add'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.games.index') }}">{{ __('games.games') }}</a></li>
        <li class="breadcrumb-item active">{{ __('games.add') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.games.index')]) !!}
        <div class="col-md-6">
            {{ Form::bsText('code') }}
            {{ Form::bsText('start_code') }}
            {{ Form::bsText('name') }}
        </div>

        <div class="col-md-6">
            {{ Form::bsText('engine') }}
            {{ Form::bsText('engine_version') }}
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {{ Form::submit('Create', ['class' => 'btn btn-success']) }}
            </div>
        </div>

    {!! Form::close() !!}
@endsection

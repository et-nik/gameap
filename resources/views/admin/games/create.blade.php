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
        <div class="row mt-2 mb-2">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                            {{ Form::bsText('code') }}
                            {{ Form::bsText('start_code') }}
                            {{ Form::bsText('name') }}
                            {{ Form::bsText('engine') }}
                            {{ Form::bsText('engine_version') }}
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        {{ Form::bsText('steam_app_id') }}
                        {{ Form::bsText('steam_app_set_config') }}
                    </div>
                </div>
                
                <div class="card mt-2">
                    <div class="card-body">
                        {{ Form::bsText('local_repository') }}
                        {{ Form::bsText('remote_repository') }}
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-12 mt-4">
            <div class="form-group">
                {{ Form::submit('Create', ['class' => 'btn btn-success']) }}
            </div>
        </div>
    {!! Form::close() !!}
@endsection

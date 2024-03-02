@php($title = __('servers.title_create'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.servers.index') }}">{{ __('servers.game_servers') }}</a></li>
        <li class="breadcrumb-item active">{{ __('servers.create') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.servers.index'), 'id' => 'adminServerForm']) !!}
        <div class="row justify-content-center mt-4">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header p-4">
                        {{ __('servers.basic_info') }}
                    </div>
                    <div class="card-body p-4">
                        {{ Form::bsText('name') }}

                        <game-mod-selector :games="{{ $games }}"></game-mod-selector>

                        <div class="form-check mt-4 mb-4">
                            {{ Form::checkbox('install', true, true, ['id' => 'install', 'class' => 'form-check-input']) }}
                            {{ Form::label('install', __('servers.install'), ['class' => 'form-check-label']) }}
                        </div>

                        <div class="col-md-4 offset-md-4">
                            <a class="btn btn-primary btn-sm btn-hide" data-bs-toggle="collapse" href="#additionalParameters" role="button" aria-expanded="false" aria-controls="additionalParameters">
                                <i class="far fa-caret-square-down"></i> {{ __('main.more') }}
                            </a>
                        </div>

                        <div class="collapse" id="additionalParameters">
                            <div class="mb-3{{ $errors->has('rcon') ? ' has-error' : '' }}">
                                {{ Form::label('rcon', null, ['class' => 'control-label']) }}

                                <div class="input-group">
                                    {{ Form::input('password', 'rcon', null,
                                        ['class' => 'form-control password', 'autocomplete' => 'new-password']) }}
                                    <button class="btn btn-outline-secondary show-hide-password" type="button"><i class="far fa-eye"></i></button>
                                </div>
                            </div>

                            {{ Form::bsInput('text', [
                                'name' => 'dir',
                                'description' => __('servers.d_dir')
                            ]) }}

                            {{ Form::bsText('su_user', 'gameap') }}
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ __('servers.ds_ip_ports') }}
                    </div>
                    <div class="card-body">
                        <ds-ip-selector :ds-list="{{ $dedicatedServers }}"></ds-ip-selector>
                        <smart-port-selector></smart-port-selector>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="mb-3">
                    {{ Form::submit(__('main.create'), ['class' => 'btn btn-success']) }}
                </div>
            </div>
        </div>

    {!! Form::close() !!}
@endsection

@section('footer-scripts')
    <style>
        .btn-hide[aria-expanded="true"] {display: none;}
    </style>

    @include('scripts.formHelper')
@endsection

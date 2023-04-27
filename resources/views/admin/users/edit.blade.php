@php($title = __('users.title_edit'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('users.users') }}</a></li>
        <li class="breadcrumb-item active">{{ __('users.title_edit') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::model($user, ['method' => 'PATCH','route' => ['admin.users.update', $user->id]]) !!}
        <div class="row mt-2 mb-2">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">

                        {{ Form::bsText('login') }}
                        {{ Form::bsEmail('email') }}
                        {{ Form::bsText('name') }}

                        <div class='mb-3'>
                            {{ Form::label('roles', __('users.roles'), ['class' => 'control-label']) }}
                            <gameap-select
                                    name="roles[]"
                                    :value="{{ json_encode($user->getRoles()) }}"
                                    :options="{{ json_encode($roleOptions) }}">
                            </gameap-select>
                        </div>

                        {{ Form::bsPassword('password') }}
                        {{ Form::bsPassword('password_confirmation') }}

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('users.servers') }}</div>
                    <div class="card-body">
                        <user-server-privileges :initial-items="{{ $user->servers }}" :user-id="{{ $user->id }}"></user-server-privileges>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                {{ Form::submit(__('main.save'), ['class' => 'btn btn-success btn-ico btn-ico-save']) }}
            </div>
        </div>
    {!! Form::close() !!}
@endsection

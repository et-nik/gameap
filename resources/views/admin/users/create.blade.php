@php($title = __('users.title_create'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('users.users') }}</a></li>
        <li class="breadcrumb-item active">{{ __('users.create') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.users.index')]) !!}
    <div class="col-md-6">
        {{ Form::bsText('login') }}
        {{ Form::bsEmail('email') }}
        {{ Form::bsPassword('password') }}
        {{ Form::bsPassword('password_confirmation') }}
        {{ Form::bsText('name') }}

        <div class='mb-3'>
            {{ Form::label('roles', __('users.roles'), ['class' => 'control-label']) }}

            {{ Form::select(
                'roles[]',
                $roles->pluck('title', 'name'),
                null,
                ['id' => 'roles', 'multiple' => 'multiple', 'class' => 'form-control selectpicker']
            ) }}
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            {{ Form::submit(__('main.create'), ['class' => 'btn btn-success']) }}
        </div>
    </div>

    {!! Form::close() !!}
@endsection

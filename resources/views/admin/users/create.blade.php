@php($title = __('users.title_create'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('admin.users.index') }}">{{ __('users.users') }}</a></li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ __('users.create') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.users.index')]) !!}
    <div class="md:w-1/2 pr-4 pl-4">
        {{ Form::bsText('login') }}
        {{ Form::bsEmail('email') }}
        {{ Form::bsPassword('password') }}
        {{ Form::bsPassword('password_confirmation') }}
        {{ Form::bsText('name') }}

        <div class='mb-3'>
            {{ Form::label('roles', __('users.roles'), ['class' => 'control-label']) }}

            <gameap-select
                    name="roles[]"
                    :options="{{ json_encode($roleOptions) }}">
            </gameap-select>
        </div>
    </div>

    <div class="md:w-full pr-4 pl-4">
        <div class="mb-3">
            {{ Form::submit(__('main.create'), ['class' => 'btn btn-success']) }}
        </div>
    </div>

    {!! Form::close() !!}
@endsection

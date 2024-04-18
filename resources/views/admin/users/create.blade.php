@php($title = __('users.title_create'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.users.index") }}', 'text':'{{ __("users.users") }}'},
        {'text':'{{ __("users.create") }}'},
    ]"></g-breadcrumbs>
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

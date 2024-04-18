@php($title = __('users.title_edit'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.users.index") }}', 'text':'{{ __("users.users") }}'},
        {'text':'{{ __("users.title_edit") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::model($user, ['method' => 'PATCH','route' => ['admin.users.update', $user->id]]) !!}
        <div class="flex flex-wrap  mt-2 mb-2">
            <div class="md:w-1/2 pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="flex-auto p-6">

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

            <div class="md:w-1/2 pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">{{ __('users.servers') }}</div>
                    <div class="flex-auto p-6">
                        <user-server-privileges :initial-items="{{ $user->servers }}" :user-id="{{ $user->id }}"></user-server-privileges>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:w-full pr-4 pl-4">
            <div class="mb-3">
                {{ Form::submit(__('main.save'), ['class' => 'btn btn-success btn-ico btn-ico-save']) }}
            </div>
        </div>
    {!! Form::close() !!}
@endsection

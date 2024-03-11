@php
    /**
     * @var \Gameap\Models\User $user
     */
@endphp

@php($title = __('profile.title'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ __('profile.profile') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    <ul class="flex flex-wrap list-none pl-0 mb-0 border border-t-0 border-r-0 border-l-0 border-b-1 border-gray-200">
        <li class="">
            <a class="inline-block py-2 px-4 no-underline active">{{ __('profile.profile') }}</a>
        </li>
        <li class="">
            <a class="inline-block py-2 px-4 no-underline" href="{{ route('tokens') }}">{{ __('tokens.tokens') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="flex flex-wrap  tab-pane container mx-auto sm:px-4 max-w-full mx-auto sm:px-4 active" id="main">
            <div class="flex flex-wrap ">
                <div class="w-full">
                    <table class="w-full max-w-full mb-4 bg-transparent table-striped table-bordered detail-view">
                        <tbody>
                        <tr>
                            <th>{{ __('profile.login') }}</th>
                            <td>{{ $user->login }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('profile.email') }}</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('profile.name') }}</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('profile.roles') }}</th>
                            <td>{!! $user->roles->implode('name', ', ') !!}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-wrap ">
                    <div class="w-full">
                        <div class="w-full">
                            <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-blue-600 text-white hover:bg-blue-600" data-bs-toggle="collapse" href="#changePassword" role="button" aria-expanded="false" aria-controls="changePassword">
                                {{ __('profile.change_password') }}
                            </a>
                        </div>

                        <div class="w-full">
                            <div class="hidden" id="changePassword">
                                <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 bg-gray-100 mt-3 mb-3">
                                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">{{ __('profile.change_password') }}</div>
                                    <div class="flex-auto p-6">
                                        {!! Form::open(['url' => route('profile.change_password')]) !!}
                                        <div class="flex flex-wrap ">
                                            <div class="w-full">{{ Form::bsPassword('current_password') }}</div>
                                            <div class="w-full">{{ Form::bsPassword('password') }}</div>
                                            <div class="w-full">{{ Form::bsPassword('password_confirmation') }}</div>
                                        </div>

                                        <div class="flex flex-wrap ">
                                            <div class="w-1/2">
                                                {{ Form::submit(__('main.change'), ['class' => 'btn btn-success']) }}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

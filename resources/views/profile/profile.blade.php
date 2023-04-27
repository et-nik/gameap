@php
    /**
     * @var \Gameap\Models\User $user
     */
@endphp

@php($title = __('profile.title'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">{{ __('profile.profile') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active">{{ __('profile.profile') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('tokens') }}">{{ __('tokens.tokens') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="row tab-pane container-fluid active" id="main">
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-bordered detail-view">
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

                <div class="row">
                    <div class="col-12">
                        <div class="col-12">
                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#changePassword" role="button" aria-expanded="false" aria-controls="changePassword">
                                {{ __('profile.change_password') }}
                            </a>
                        </div>

                        <div class="col-12">
                            <div class="collapse" id="changePassword">
                                <div class="card bg-light mt-3 mb-3">
                                    <div class="card-header">{{ __('profile.change_password') }}</div>
                                    <div class="card-body">
                                        {!! Form::open(['url' => route('profile.change_password')]) !!}
                                        <div class="row">
                                            <div class="col-12">{{ Form::bsPassword('current_password') }}</div>
                                            <div class="col-12">{{ Form::bsPassword('password') }}</div>
                                            <div class="col-12">{{ Form::bsPassword('password_confirmation') }}</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
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

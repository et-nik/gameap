@php($title = __('profile.title'))

@extends('layouts.main')

@section('content')
    @include('components.form.errors_block')

    <div class="row">
        <div class="col-md-12">
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
            <div class="col-md-12">
                <div class="col-md-12">
                    <a class="btn btn-primary" data-toggle="collapse" href="#changePassword" role="button" aria-expanded="false" aria-controls="changePassword">
                        {{ __('profile.change_password') }}
                    </a>
                </div>

                <div class="col-md-12">
                    <div class="collapse" id="changePassword">
                        <div class="card bg-light mt-3 mb-3">
                            <div class="card-header">{{ __('profile.change_password') }}</div>
                            <div class="card-body">
                                {!! Form::open(['url' => route('profile.change_password')]) !!}
                                    <div class="row">
                                        <div class="col-md-12">{{ Form::bsPassword('current_password') }}</div>
                                        <div class="col-md-12">{{ Form::bsPassword('password') }}</div>
                                        <div class="col-md-12">{{ Form::bsPassword('password_confirmation') }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
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
@endsection

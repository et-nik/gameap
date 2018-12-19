@php($title = "Profile")

@extends('layouts.main')

@section('content')
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
    </div>
@endsection

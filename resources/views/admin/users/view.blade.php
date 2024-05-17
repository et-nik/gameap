@php($title = $user->login)

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.users.index") }}', 'text':'{{ __("users.users") }}'},
        {'text':'{{ $user->login }}'},
    ]"></g-breadcrumbs>
@endsection

{{-- Content --}}
@section('content')
    <div class="flex flex-wrap ">
        <div class="md:w-full pr-4 pl-4">
            <table class="w-full max-w-full mb-4 bg-transparent table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <td>{{ __('users.login') }}</td>
                        <td>{{ $user->login }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('users.name') }}</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('users.roles') }}</td>
                        <td>{!! $user->roles->implode('name', ', ') !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@php($title = $user->login)

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('admin.users.index') }}">{{ __('users.users') }}</a></li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ $user->login }}</li>
    </ol>
@endsection

{{-- Content --}}
@section('content')
    <div class="flex flex-wrap ">
        <div class="md:w-full pr-4 pl-4">
            <table class="w-full max-w-full mb-4 bg-transparent table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>{{ __('users.login') }}</th>
                        <td>{{ $user->login }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('users.name') }}</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('users.roles') }}</th>
                        <td>{!! $user->roles->implode('name', ', ') !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
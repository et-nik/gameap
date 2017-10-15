@php($title = 'Users list')

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li><a href="/">GameAP</a></li>
        <li>Users</li>
    </ol>
@endsection

@section('content')
    <a class='btn btn-success btn-sm' href="{{ route('admin.users.create') }}">Create</a>
    <hr>

    @include('components.grid', [
        'modelsList' => $users,
        'labels' => ['Login', 'Email'],
        'attributes' => ['login', 'email'],
        'viewRoute' => 'admin.users.show',
        'editRoute' => 'admin.users.edit',
        'destroyRoute' => 'admin.users.destroy',
    ])

    {!! $users->links() !!}
@endsection
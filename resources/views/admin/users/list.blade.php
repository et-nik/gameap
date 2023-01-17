@php($title = __('users.title_list'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">{{ __('users.users') }}</li>
    </ol>
@endsection

@section('content')
    <div class="page-list-menu mb-3">
        <a class='btn btn-success' href="{{ route('admin.users.create') }}">
            <span class="fa fa-plus-square"></span>&nbsp;{{ __('main.create') }}
        </a>
    </div>

    @include('components.grid', [
        'modelsList' => $users,
        'labels' => [__('users.login'), 'Email'],
        'attributes' => ['login', 'email'],
        'viewRoute' => 'admin.users.show',
        'editRoute' => 'admin.users.edit',
        'destroyRoute' => 'admin.users.destroy',
    ])

    {!! $users->links() !!}
@endsection
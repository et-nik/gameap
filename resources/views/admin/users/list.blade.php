@php($title = __('users.title_list'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ __('users.users') }}</li>
    </ol>
@endsection

@section('content')
    <div class="page-list-menu mb-3">
        <a class='inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-green-500 text-white hover:bg-green-600' href="{{ route('admin.users.create') }}">
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
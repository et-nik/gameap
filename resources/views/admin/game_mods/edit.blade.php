@php($title = __('games.title_edit_mod'))

@extends('layouts.main')

@section('content')
    @include('components.form.errors_block')

    <ul class="flex flex-wrap list-none pl-0 mb-0 border border-t-0 border-r-0 border-l-0 border-b-1 border-gray-200">
        <li class="">
            <a class="inline-block py-2 px-4 no-underline active" data-bs-toggle="tab" href="#main">{{ __('games.main') }}</a>
        </li>
        <li class="">
            <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" href="#game-servers-commands">{{ __('games.servers_commands') }}</a>
        </li>
        <li class="">
            <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" href="#vars">{{ __('games.vars') }}</a>
        </li>
        <li class="">
            <a class="inline-block py-2 px-4 no-underline" data-bs-toggle="tab" href="#fast-rcon">{{ __('games.fast_rcon_commands') }}</a>
        </li>
    </ul>
@endsection

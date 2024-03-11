@php($title = $game->name)

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('admin.games.index') }}">{{ __('games.games') }}</a></li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ $game->name }}</li>
    </ol>
@endsection

{{-- Content --}}
@section('content')
    
@endsection
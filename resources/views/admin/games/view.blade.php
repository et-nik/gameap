@php($title = $game->name)

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.games.index") }}', 'text':'{{ __("games.games") }}'},
        {'text':'{{ $game->name }}'},
    ]"></g-breadcrumbs>
@endsection

{{-- Content --}}
@section('content')
    
@endsection
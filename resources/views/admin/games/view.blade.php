@php($title = $game->name)

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li><a href="/">GameAP</a></li>
        <li><a href="{{ route('admin.games.index') }}">Games</a></li>
        <li>{{ $game->name }}</li>
    </ol>
@endsection

{{-- Content --}}
@section('content')
    
@endsection
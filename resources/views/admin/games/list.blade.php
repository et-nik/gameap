@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li><a href="/">GameAP</a></li>
        <li>Games</li>
    </ol>
@endsection

@section('content')
    <a class='btn btn-success btn-sm' href="{{ route('admin.games.create') }}">Create</a>
    <ul>
        @foreach($games as $game)
            <li>{{ $game->code }} [{{ $game->engine_version }}]</li>
        @endforeach
    </ul>
@endsection




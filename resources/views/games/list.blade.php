@extends('layouts.main')

@section('content')
    <ul>
        @foreach($games as $game)
            <li>{{ $game->code }}</li>
        @endforeach
    </ul>
@endsection
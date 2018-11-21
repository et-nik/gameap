@php($title = 'Games servers list')

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">Games</li>
    </ol>
@endsection

@section('content')
    <a class='btn btn-success btn-sm' href="{{ route('admin.games.create') }}">Create</a>
    <hr>

    @include('components.grid', [
        'modelsList' => $games,
        'labels' => ['Name', 'Code', 'Engine', 'Mods'],
        'attributes' => ['name', 'code', 'engine', 'mods'],
        'viewRoute' => 'admin.games.show',
        'editRoute' => 'admin.games.edit',
        'destroyRoute' => 'admin.games.destroy',
    ])

    {!! $games->links() !!}
@endsection
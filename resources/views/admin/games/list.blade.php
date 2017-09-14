@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li><a href="/">GameAP</a></li>
        <li>Games</li>
    </ol>
@endsection

@section('content')
    <a class='btn btn-success btn-sm' href="{{ route('admin.games.create') }}">Create</a>
    <hr>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <td>Name</td>
                <td>Code</td>
                <td>Engine</td>
                <td style="width: 25%;">Actions</td>
            </tr>
        </thead>
        
        <tbody>
            @foreach($games as $game)
                <tr>
                    <td>{{ $game->name }}</td>
                    <td>{{ $game->code }}</td>
                    <td>{{ $game->engine }} {{ $game->engine_version }}</td>
                    
                    <td>
                        <a class="btn btn-small btn-success btn-sm" href="{{ route('admin.games.show', $game->code) }}">View</a>
                        <a class="btn btn-small btn-info btn-sm" href="{{ route('admin.games.edit', $game->code) }}">Edit</a>

                        {{ Form::open(array('url' => route('admin.games.destroy', $game->code), 'style'=>'display:inline')) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-warning btn-sm')) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $games->links() !!}
@endsection
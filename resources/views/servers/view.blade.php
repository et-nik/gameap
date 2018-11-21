@php($title = 'Game server')

@extends('layouts.main')

@section('content')
    <h2>Commands</h2>
    <div id="serverControl">
        @if (!$server->processActive())
            <a class="btn btn-large btn-success" href="#" @click="startServer({{ $server->id }})"><span class="fa fa-play"></span>&nbsp;Start</a>
        @endif

        @if ($server->processActive())
            <a class="btn btn-large btn-danger" href="#" @click="stopServer({{ $server->id }})"><span class="fa fa-stop"></span>&nbsp;Stop</a>
        @endif

        <a class="btn btn-large btn-warning" href="#" @click="restartServer({{ $server->id }})"><span class="fa fa-repeat"></span>&nbsp;Restart</a>
        <a class="btn btn-large btn-info" href="#" @click="updateServer({{ $server->id }})"><span class="fa fa-refresh"></span>&nbsp;Update</a>
    </div>
    
    <h2>Tools</h2>
    <a class="btn btn-large btn-info" href="{{ route('servers.filemanager', ['server' => $server->id]) }}"><span class="fa fa-folder-open"></span>&nbsp;Files</a>


    <h2>Status</h2>

    <h2>Last actions</h2>
@endsection
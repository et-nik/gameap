@php($title = "GDaemon task")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li><a href="/">GameAP</a></li>
        <li><a href="{{ route('admin.gdaemon_tasks.index') }}">GDaemon tasks</a></li>
        <li>Task</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-2">Task</div>
        <div class="col-md-10">{{ $gdaemonTask->task }}</div>
        
        <div class="col-md-2">Created</div>
        <div class="col-md-10">{{ $gdaemonTask->created_at }}</div>
        
        <div class="col-md-2">Updated</div>
        <div class="col-md-10">{{ $gdaemonTask->updated_at }}</div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <pre class="console">{{ $gdaemonTask->output }}</pre>
        </div>
    </div>
@endsection
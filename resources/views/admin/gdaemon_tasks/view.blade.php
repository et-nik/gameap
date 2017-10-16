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
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('task', 'Task:') !!}
                {!! $gdaemonTask->task !!}
            </div>
            
            <div class="form-group">
                {!! Form::label('created_at', 'Created:') !!}
                {!! $gdaemonTask->created_at !!}
            </div>
            
            <div class="form-group">
                {!! Form::label('updated_at', 'Updated:') !!}
                {!! $gdaemonTask->updated_at !!}
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <pre class="console">{!! $gdaemonTask->output !!}</pre>
        </div>
    </div>
@endsection
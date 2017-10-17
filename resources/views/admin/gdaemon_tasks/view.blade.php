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
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>Task</th>
                        <td>{!! $gdaemonTask->task !!}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($gdaemonTask->status == 'success')
                                <span class="label label-success">{{ $gdaemonTask->status }}</span>
                            @elseif($gdaemonTask->status == 'error')
                                <span class="label label-danger">{{ $gdaemonTask->status }}</span>
                            @elseif($gdaemonTask->status == 'waiting' || $gdaemonTask->status == 'working')
                                <span class="label label-warning">{{ $gdaemonTask->status }}</span>
                            @else
                                <span class="label label-default">{{ $gdaemonTask->status }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td>{!! $gdaemonTask->created_at !!}</td>
                    </tr>
                    <tr>
                        <th>Updated</th>
                        <td>{!! $gdaemonTask->updated_at !!}</td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <pre class="console">{!! $gdaemonTask->output !!}</pre>
        </div>
    </div>
@endsection
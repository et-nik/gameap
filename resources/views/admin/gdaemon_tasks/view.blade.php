@php($title = __('title_view'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.gdaemon_tasks.index') }}">{{ __('gdaemon_tasks.gdaemon_tasks') }}</a></li>
        <li class="breadcrumb-item">{{ __('gdaemon_tasks.task') }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>{{ __('gdaemon_tasks.task') }}</th>
                        <td>{!! $gdaemonTask->task !!}</td>
                    </tr>
                    <tr>
                        <th>{{ __('gdaemon_tasks.status') }}</th>
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
                        <th>{{ __('gdaemon_tasks.created') }}</th>
                        <td>{!! $gdaemonTask->created_at !!}</td>
                    </tr>
                    <tr>
                        <th>{{ __('gdaemon_tasks.updated') }}</th>
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
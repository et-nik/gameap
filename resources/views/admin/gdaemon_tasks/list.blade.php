@php($title = 'GDaemon Tasks list')

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li><a href="/">GameAP</a></li>
        <li>GDaemon Tasks</li>
    </ol>
@endsection

@section('content')
    @include('components.grid', [
        'modelsList' => $gdaemonTasks,
        'labels' => ['Task', 'Status'],
        'attributes' => ['task', 'status'],
        'viewRoute' => 'admin.gdaemon_tasks.show'
    ])

    {!! $gdaemonTasks->links() !!}
@endsection
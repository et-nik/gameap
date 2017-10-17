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
        'labels' => [
            'Task', 
            'Status', 
            'Created', 
            'Updated'
        ],
        'attributes' => [
            'task',
            [/* status */ 'lambda', function($gdaemonTaskModel) {
                if ($gdaemonTaskModel->status == 'success') {
                    $label = 'label-success';
                } elseif ($gdaemonTaskModel->status == 'error') {
                    $label = 'label-danger';
                } elseif ($gdaemonTaskModel->status == 'waiting' || $gdaemonTaskModel->status == 'working') {
                    $label = 'label-warning';
                } else {
                    $label = 'label-default';
                }
                
                return "<span class=\"label {$label}\">{$gdaemonTaskModel->status}</span>";
            }], 
            'created_at', 
            'updated_at'
        ],
        'viewRoute' => 'admin.gdaemon_tasks.show'
    ])

    {!! $gdaemonTasks->links() !!}
@endsection
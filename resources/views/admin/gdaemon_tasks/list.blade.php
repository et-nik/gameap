@php($title = __('gdaemon_tasks.title_list'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">{{ __('gdaemon_tasks.gdaemon_tasks') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.grid', [
        'modelsList' => $gdaemonTasks,
        'labels' => [
            __('gdaemon_tasks.task'), 
            __('gdaemon_tasks.status'), 
            __('gdaemon_tasks.created'), 
            __('gdaemon_tasks.updated')
        ],
        'attributes' => [
            'task',
            [/* status */ 'lambda', function($gdaemonTaskModel) {
                if ($gdaemonTaskModel->status == 'success') {
                    $label = 'badge-success';
                } elseif ($gdaemonTaskModel->status == 'error') {
                    $label = 'badge-danger';
                } elseif ($gdaemonTaskModel->status == 'waiting' || $gdaemonTaskModel->status == 'working') {
                    $label = 'badge-warning';
                } elseif ($gdaemonTaskModel->status == 'canceled') {
                    $label = 'badge-secondary';
                } else {
                    $label = 'badge-default';
                }
                
                return "<span class=\"badge {$label}\">{$gdaemonTaskModel->status}</span>";
            }], 
            'created_at', 
            'updated_at'
        ],
        'viewRoute' => 'admin.gdaemon_tasks.show'
    ])

    {!! $gdaemonTasks->links() !!}
@endsection

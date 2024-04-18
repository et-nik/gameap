@php($title = __('gdaemon_tasks.title_list'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'text':'{{ __("gdaemon_tasks.gdaemon_tasks") }}'},
    ]"></g-breadcrumbs>
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
                    $label = 'text-bg-success';
                } elseif ($gdaemonTaskModel->status == 'error') {
                    $label = 'text-bg-danger';
                } elseif ($gdaemonTaskModel->status == 'waiting' || $gdaemonTaskModel->status == 'working') {
                    $label = 'text-bg-warning';
                } elseif ($gdaemonTaskModel->status == 'canceled') {
                    $label = 'text-bg-secondary';
                } else {
                    $label = 'text-bg-default';
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

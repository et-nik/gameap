@php($title = __('gdaemon_tasks.title_list'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ __('gdaemon_tasks.gdaemon_tasks') }}</li>
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

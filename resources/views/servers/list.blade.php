@php($title = __('servers.title_servers_list'))

@extends('layouts.main')

@section('content')
    @include('components.grid', [
         'modelsList' => $servers,
         'labels' => [__('servers.name'), __('servers.ip_port'), __('servers.status'), __('servers.commands')],
         'attributes' => [
            'name',
            ['twoSeparatedValues', ['server_ip', ':', 'server_port']],
            ['lambda', function ($serverModel) {
                return $serverModel->processActive()
                    ? '<span class="badge badge-success">' . __('servers.online') . '</span>'
                    : '<span class="badge badge-danger">' . __('servers.offline') . '</span>';
            }],
            ['lambda', function($serverModel) {
                $buttons = '';

                if (!$serverModel->processActive()) {
                    $buttons .= '<a class="btn btn-small btn-success btn-sm" href="#" @click="startServer(' . $serverModel->id . ')">
                            <span class="fa fa-play"></span>&nbsp;' . __('servers.start') . '
                        </a>&nbsp;';
                }

                if ($serverModel->processActive()) {
                    $buttons .= '<a class="btn btn-small btn-danger btn-sm" href="#" @click="stopServer(' . $serverModel->id . ')">
                            <span class="fa fa-stop"></span>&nbsp;' . __('servers.stop') . '
                        </a>&nbsp;';
                }

                $buttons .= '<a class="btn btn-small btn-warning btn-sm" href="#" @click="restartServer(' . $serverModel->id . ')">
                        <span class="fa fa-redo"></span>&nbsp;' . __('servers.restart') . '
                    </a>&nbsp;';

                $buttons .= '<a class="btn btn-small btn-primary btn-sm" href="/servers/' . $serverModel->id . '">' . __('servers.control') . '&nbsp;
                        <span class="fa fa-angle-double-right"></span>
                    </a>&nbsp;';

                return '<div id="serverControl">' . $buttons . '</div>';
            }]
         ],
     ])
@endsection
@php($title = __('servers.title_servers_list'))

@extends('layouts.main')

@section('content')
    <?php //TODO: Remove after fixing serverControl js?>
    <div id="serverControl"></div>

    @include('components.grid', [
        'modelsList' => $servers,
        'labels' => [__('servers.name'), __('servers.ip_port'), __('servers.status'), __('servers.commands')],
        'attributes' => [
            'name',
            ['twoSeparatedValues', ['server_ip', ':', 'server_port']],
            ['lambda', function ($serverModel) {
                if ($serverModel->blocked) {
                    return '<span class="badge text-bg-secondary">' . __('servers.blocked') . '</span>';
                }

                if (!$serverModel->enabled) {
                    return '<span class="badge text-bg-secondary">' . __('servers.disabled') . '</span>';
                }

                if ($serverModel->installed === $serverModel::NOT_INSTALLED) {
                    return '<span class="badge text-bg-secondary">' . __('servers.not_installed') . '</span>';
                }

                if ($serverModel->installed === $serverModel::INSTALLATION_PROCESS) {
                    return '<span class="badge text-bg-warning">' . __('servers.installation') . '</span>';
                }

                return $serverModel->processActive()
                    ? '<span class="badge text-bg-success">' . __('servers.online') . '</span>'
                    : '<span class="badge text-bg-danger">' . __('servers.offline') . '</span>';
            }],
            ['lambda', function($serverModel) {
                if (!$serverModel->enabled || $serverModel->blocked) {
                    return '';
                }

                $buttons = '';

                if ($serverModel->installed === $serverModel::INSTALLED) {
                    if (!$serverModel->processActive() && Auth::user()->can('server-start', $serverModel)) {
                        $buttons .= '<a class="btn btn-small btn-success btn-sm" href="#" @click="startServer(' . $serverModel->id . ')">
                                <span class="fa fa-play"></span><span class="d-none d-xl-inline">&nbsp;' . __('servers.start') . '</span>
                            </a>&nbsp;';
                    }

                    if ($serverModel->processActive() && Auth::user()->can('server-stop', $serverModel)) {
                        $buttons .= '<a class="btn btn-small btn-danger btn-sm" href="#" @click="stopServer(' . $serverModel->id . ')">
                                <span class="fa fa-stop"></span><span class="d-none d-xl-inline">&nbsp;' . __('servers.stop') . '</span>
                            </a>&nbsp;';
                    }

                    if (Auth::user()->can('server-restart', $serverModel)) {
                        $buttons .= '<a class="btn btn-small btn-warning btn-sm" href="#" @click="restartServer(' . $serverModel->id . ')">
                                <span class="fa fa-redo"></span><span class="d-none d-xl-inline">&nbsp;' . __('servers.restart') . '</span>
                            </a>&nbsp;';
                    }
                } else if ($serverModel->installed === $serverModel::NOT_INSTALLED && Auth::user()->can('server-update', $serverModel)) {
                    $buttons .= '<a class="btn btn-small btn-warning btn-sm" href="#" @click="installServer(' . $serverModel->id . ')">
                            <span class="fas fa-download"></span><span class="d-none d-xl-inline">&nbsp;' . __('servers.install') . '</span>
                        </a>&nbsp;';
                }

                if (Auth::user()->can('control', $serverModel)) {
                    $buttons .= '<a class="btn btn-small btn-primary btn-sm" href="/servers/' . $serverModel->id . '"><span class="d-none d-xl-inline">' . __('servers.control') . '&nbsp;</span>
                            <span class="fa fa-angle-double-right"></span>
                        </a>&nbsp;';
                }

                return '<div class="server-control">' . $buttons . '</div>';
            }]
        ],
    ])

    {!! $servers->links() !!}
@endsection

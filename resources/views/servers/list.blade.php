@php($title = 'Game servers list')

@extends('layouts.main')

@section('content')
    @include('components.grid', [
         'modelsList' => $servers,
         'labels' => ['Name', 'IP:Port', 'Status', 'Commands'],
         'attributes' => [
            'name',
            ['twoSeparatedValues', ['server_ip', ':', 'server_port']],
            ['lambda', function ($serverModel) {
                return $serverModel->processActive()
                    ? '<span class="label label-success">online</span>'
                    : '<span class="label label-danger">offline</span>';
            }],
            ['lambda', function($serverModel) {
                $buttons = '';

                if (!$serverModel->processActive()) {
                    $buttons .= '<a class="btn btn-small btn-success btn-sm" href="#"><span class="fa fa-play"></span>&nbsp;Start</a>&nbsp;';
                }

                if ($serverModel->processActive()) {
                    $buttons .= '<a class="btn btn-small btn-success btn-sm" href="#"><span class="fa fa-stop"></span>&nbsp;Stop</a>&nbsp;';
                }

                $buttons .= '<a class="btn btn-small btn-warning btn-sm" href="#"><span class="fa fa-repeat"></span>&nbsp;Restart</a>&nbsp;';
                $buttons .= '<a class="btn btn-small btn-default btn-sm" href="/servers/' . $serverModel->id . '">Control&nbsp;<span class="fa fa-angle-double-right"></span></a>&nbsp;';

                return $buttons;
            }]
         ],
     ])
@endsection
@php($title = __('servers.settings') )

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('servers') }}">{{ __('servers.game_servers') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('servers.control', ['server' => $server->id]) }}">{{ __('servers.control') }}</a></li>
        <li class="breadcrumb-item active">{{ __('servers.settings') }}</li>
    </ol>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::model($server, ['method' => 'PATCH', 'route' => ['servers.updateSettings', $server->id], 'id' => 'adminServerForm']) !!}
                    @foreach ($server->gameMod->vars as $var)
                        @if ($var['admin_var'])
                            @cannot('admin roles & permissions')
                                @continue
                            @endcannot
                        @endif

                        <div class="col-12">
                            {{ Form::bsText(
                                    'vars[' . $var['var'] . ']',
                                    (isset($server->vars[ $var['var'] ]))
                                        ? $server->vars[ $var['var'] ]
                                        : $var['default'],
                                    $var['info']
                                ) }}
                        </div>
                    @endforeach

                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-group">
                                {{ Form::submit(__('main.save'), ['class' => 'btn btn-success']) }}
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
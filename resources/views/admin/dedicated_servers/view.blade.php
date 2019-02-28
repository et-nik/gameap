@php($title = __('dedicated_servers.title_view'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.dedicated_servers.index') }}">Dedicated servers</a></li>
        <li class="breadcrumb-item active">View</li>
    </ol>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>{{ __('dedicated_servers.name') }}</th>
                        <td>{!! $dedicatedServer->name !!}</td>
                    </tr>
                    <tr>
                        <th>{{ __('dedicated_servers.gdaemon_api_key') }}</th>
                        <td>{!! $dedicatedServer->gdaemon_api_key !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{--TODO: Game servers info here!--}}

    {{--TODO: Stats here!--}}

@endsection

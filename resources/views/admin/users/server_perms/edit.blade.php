@php(
/**
 * @var \Illuminate\Database\Eloquent\Collection $permissions
 * @var array $allPermissions
 * @var array $checkedPermissions
 * @var \Gameap\Models\User $user
 * @var \Gameap\Models\Server $server
 */

    $title = __('users.title_server_permissions_edit')
)

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('users.users') }}</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.users.edit', $user->id) }}">{{ __('users.title_edit') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('users.server_permission_edit') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')
    {!! Form::model($user, ['method' => 'PATCH','route' => ['admin.users.update_server_permissions', $user->id, $server->id]]) !!}
        <div class="row mt-2 mb-2">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @foreach ($allPermissions as $permission)
                            <div class="custom-control custom-switch m-3">
                                {{ Form::checkbox("permissions[{$permission}]", 'disallow', !in_array($permission, $checkedPermissions), ['id' => $permission, 'class' => 'custom-control-input']) }}
                                {{ Form::label($permission, __('users.permission_names.' . $permission), ['class' => 'custom-control-label']) }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('servers.server_info') }}</div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered detail-view">
                            <tbody>
                                <tr>
                                    <th>{{ __('servers.name') }}</th>
                                    <td>{!! $server->name !!}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('servers.game') }}</th>
                                    <td>{!! $server->game->name !!}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('servers.ip_port') }}</th>
                                    <td>{!! $server->server_ip !!}:{!! $server->server_port !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {{ Form::submit(__('main.save'), ['class' => 'btn btn-success']) }}
            </div>
        </div>
    {!! Form::close() !!}
@endsection
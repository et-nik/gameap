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

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('admin.users.index') }}">{{ __('users.users') }}</a></li>
        <li class="inline-block px-2 py-2 text-gray-700">
            <a href="{{ route('admin.users.edit', $user->id) }}">{{ __('users.title_edit') }}</a>
        </li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ __('users.server_permission_edit') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')
    {!! Form::model($user, ['method' => 'PATCH','route' => ['admin.users.update_server_permissions', [$user->id, $server->id]]]) !!}
        <div class="flex flex-wrap  mt-2 mb-2">
            <div class="md:w-1/2 pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="flex-auto p-6">
                        @foreach ($allPermissions as $permission)
                            <div class="mb-3 m-6">
                                <span class="switch switch-success switch-checked-danger">
                                    {{ Form::checkbox("permissions[{$permission}]", 'disallow', !in_array($permission, $checkedPermissions), ['id' => $permission, 'class' => 'switch']) }}
                                    {{ Form::label($permission, __('users.permission_names.' . $permission)) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="md:w-1/2 pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">{{ __('servers.server_info') }}</div>
                    <div class="flex-auto p-6">
                        <table class="w-full max-w-full mb-4 bg-transparent table-striped table-bordered detail-view">
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

        <div class="md:w-full pr-4 pl-4">
            <div class="mb-3">
                {{ Form::submit(__('main.save'), ['class' => 'btn btn-success']) }}
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@php($title = "Edit User")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Edit User</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::model($user, ['method' => 'PATCH','route' => ['admin.users.update', $user->id]]) !!}
        <div class="row mt-2 mb-2">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">

                        {{ Form::bsText('login') }}
                        {{ Form::bsEmail('email') }}
                        {{ Form::bsText('name') }}

                        <div class='form-group'>
                            {{ Form::label('roles', 'Roles', ['class' => 'control-label']) }}
                            {{ Form::select('roles[]', $roles->pluck('name', 'id'), null, ['id' => 'roles', 'multiple' => 'multiple', 'class' => 'form-control selectpicker']) }}
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header">Servers</div>
                    <div class="card-body">

                        <user-server-privileges :initial-items="{{ $user->servers }}"></user-server-privileges>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
            </div>
        </div>
    {!! Form::close() !!}
@endsection

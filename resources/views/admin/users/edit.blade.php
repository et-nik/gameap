@php($title = "Edit User")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li><a href="/">GameAP</a></li>
        <li><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li>Edit User</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::model($user, ['method' => 'PATCH','route' => ['admin.users.update', $user->id]]) !!}
    <div class="col-md-6">
        {{ Form::bsText('login') }}
        {{ Form::bsEmail('email') }}
        {{ Form::bsText('name') }}

        <div class='form-group'>
            {{ Form::label('roles[]', 'Roles', ['class' => 'control-label']) }}
            {{ Form::select('roles[]', $roles->pluck('name', 'id'), null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

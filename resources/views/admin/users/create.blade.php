@php($title = "Create User")

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.users.index')]) !!}
    <div class="col-md-6">
        {{ Form::bsText('login') }}
        {{ Form::bsEmail('email') }}
        {{ Form::bsPassword('password') }}
        {{ Form::bsPassword('password_confirmation') }}
        {{ Form::bsText('name') }}

        <div class='form-group'>
            {{ Form::label('roles', 'Roles', ['class' => 'control-label']) }}
            {{ Form::select('roles[]', $roles->pluck('name', 'id'), null, ['id' => 'roles', 'multiple' => 'multiple', 'class' => 'form-control selectpicker']) }}
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            {{ Form::submit('Create', ['class' => 'btn btn-success']) }}
        </div>
    </div>

    {!! Form::close() !!}
@endsection
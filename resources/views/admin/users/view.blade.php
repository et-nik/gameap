@php($title = $user->login)

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li><a href="/">GameAP</a></li>
        <li><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li>{{ $user->login }}</li>
    </ol>
@endsection

{{-- Content --}}
@section('content')

@endsection
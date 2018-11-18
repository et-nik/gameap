@php($title = 'File Manager')

@extends('layouts.main')

@section('content')
    <file-manager server-id="{{ $server->id }}">
    </file-manager>
@endsection
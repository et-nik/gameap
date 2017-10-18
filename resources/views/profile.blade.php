@php($title = "Profile")

@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                <tr>
                    <th>Login</th>
                    <td>{{ $user->login }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Roles</th>
                    <td>{!! $user->roles->implode('name', ', ') !!}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

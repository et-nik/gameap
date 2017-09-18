@extends('layouts.main')

@section('header-scripts')
@endsection

@section('content')
    <div class="row">
        Azaza
    </div>

    <ul id="app">
        <ul v-for="message in messages">
            <li>@{{ message }}</li>
        </ul>
    </ul>
@endsection

@section('footer-scripts')
@endsection
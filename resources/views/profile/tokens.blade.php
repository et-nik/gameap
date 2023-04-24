@php
    /**
     * @var \Gameap\Models\PersonalAccessToken[] $tokens
     */
@endphp

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item active">{{ __('tokens.tokens') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    @if ($token = Session::get('token'))
        <div class="alert alert-success">
            <div class="input-group">
                <input type="text" id="token" value="{{ $token }}" class="form-control">

                <span class="input-group-btn">
                <button id="copy-token" class="btn btn-secondary" type="button">
                    <i class="fas fa-copy"></i>
                </button>
            </span>
            </div>
        </div>
    @endif

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('profile') }}">{{ __('profile.profile') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active">{{ __('tokens.tokens') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="row tab-pane container-fluid active" id="main">
            <div class="row">
                <div class="col-12">

                    <div class="row mb-2">
                        <div class="col-6">
                            <a class='btn btn-success mt-2' href="{{ route('tokens.generate') }}">
                                <i class="fa fa-plus-square"></i> {{ __('tokens.generate_token') }}
                            </a>
                        </div>
                    </div>

                    @include('components.grid', [
                        'modelsList' => $tokens,
                        'labels'     => [
                            __('tokens.name'),
                            __('tokens.abilities'),
                            __('tokens.last_used')
                        ],
                        'attributes' => [
                            'name',
                            ['lambda', function (\Gameap\Models\PersonalAccessToken $accessToken) {
                                return implode(', ', $accessToken->abilities);
                            }],
                            ['lambda', function (\Gameap\Models\PersonalAccessToken $accessToken) {
                                return $accessToken->last_used_at ?? __('main.never');
                            }]
                        ],
                        'destroyRoute' => 'tokens.destroy',
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('#copy-token').addEventListener('click', function() {
                const text = document.getElementById('token').value;
                try {
                    navigator.clipboard.writeText(text);
                    console.log('Content copied to clipboard');
                } catch (err) {
                    console.error('Failed to copy: ', err);
                }
            });
        });
    </script>
@endsection

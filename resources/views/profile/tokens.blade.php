@php
    /**
     * @var \Gameap\Models\PersonalAccessToken[] $tokens
     */
@endphp

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'text':'{{ __("tokens.tokens") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    @include('components.form.errors_block')

    @if ($token = Session::get('token'))
        <div class="relative px-3 py-3 mb-4 border rounded bg-green-200 border-green-300 text-green-800">
            <div class="relative flex items-stretch w-full">
                <input type="text" id="token" value="{{ $token }}" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded">

                <span class="input-group-btn">
                <button id="copy-token" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-gray-600 text-white hover:bg-gray-700" type="button">
                    <i class="fas fa-copy"></i>
                </button>
            </span>
            </div>
        </div>
    @endif

    <ul class="flex flex-wrap list-none pl-0 mb-0 border border-t-0 border-r-0 border-l-0 border-b-1 border-gray-200">
        <li class="">
            <a class="inline-block py-2 px-4 no-underline" href="{{ route('profile') }}">{{ __('profile.profile') }}</a>
        </li>
        <li class="">
            <a class="inline-block py-2 px-4 no-underline active">{{ __('tokens.tokens') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="flex flex-wrap  tab-pane container mx-auto sm:px-4 max-w-full mx-auto sm:px-4 active" id="main">
            <div class="flex flex-wrap ">
                <div class="w-full">

                    <div class="flex flex-wrap  mb-2">
                        <div class="w-1/2">
                            <a class='inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-green-500 text-white hover:bg-green-600 mt-2' href="{{ route('tokens.generate') }}">
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
            const el = document.querySelector('#copy-token');

            if (el !== undefined && el !== null) {
                el.addEventListener('click', function() {
                    const text = document.getElementById('token').value;
                    try {
                        navigator.clipboard.writeText(text);
                        console.log('Content copied to clipboard');
                    } catch (err) {
                        console.error('Failed to copy: ', err);
                    }
                });
            }
        });
    </script>
@endsection

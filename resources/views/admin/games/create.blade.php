@php($title = __('games.title_add'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.games.index") }}', 'text':'{{ __("games.games") }}'},
        {'text':'{{ __("games.add") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.games.index')]) !!}
        <div class="flex flex-wrap mt-2 mb-2">
            <div class="md:w-1/2 pr-8">
                <n-card
                        title="{{ __('games.basic_info') }}"
                        class="mb-3"
                        header-class="bg-stone-100"
                        :segmented="{
                          content: true,
                          footer: 'soft'
                        }"
                >
                    {{ Form::bsText('code') }}
                    {{ Form::bsText('name') }}
                    {{ Form::bsText('engine') }}
                    {{ Form::bsText('engine_version') }}
                </n-card>
            </div>

            <div class="md:w-1/2">
                <n-card
                        title="{{ __('games.steam_info') }}"
                        class="mb-3"
                        header-class="bg-stone-100"
                        :segmented="{
                          content: true,
                          footer: 'soft'
                        }"
                >
                    {{ Form::bsText('steam_app_id_linux') }}
                    {{ Form::bsText('steam_app_id_windows') }}
                    {{ Form::bsText('steam_app_set_config') }}
                </n-card>
            </div>

            <div class="md:w-1/2 pr-8">
                <n-card
                        title="{{ __('games.repositories_local') }}"
                        class="mb-3"
                        header-class="bg-stone-100"
                        :segmented="{
                      content: true,
                      footer: 'soft'
                    }"
                >
                    {{ Form::bsText('local_repository_linux') }}
                    {{ Form::bsText('local_repository_windows') }}
                </n-card>
            </div>

            <div class="md:w-1/2">
                <n-card
                        title="{{ __('games.repositories_remote') }}"
                        class="mb-3"
                        header-class="bg-stone-100"
                        :segmented="{
                      content: true,
                      footer: 'soft'
                    }"
                >
                    {{ Form::bsText('remote_repository_linux') }}
                    {{ Form::bsText('remote_repository_windows') }}
                </n-card>
            </div>
        </div>

        <div class="md:w-full mt-4 mb-8">
            <g-button color="green">
                <i class="fas fa-save"></i></i>&nbsp;{{ __('main.create') }}
            </g-button>
        </div>
    {!! Form::close() !!}
@endsection

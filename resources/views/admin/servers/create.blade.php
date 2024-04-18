@php($title = __('servers.title_create'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.servers.index") }}', 'text':'{{ __("servers.game_servers") }}'},
        {'text':'{{ __("servers.create") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.servers.index'), 'id' => 'adminServerForm']) !!}
        <div class="flex flex-wrap ">
            <div class="md:w-2/5 pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                        {{ __('servers.basic_info') }}
                    </div>
                    <div class="flex-auto p-6">
                        {{ Form::bsText('name') }}

                        <game-mod-selector :games="{{ $games }}"></game-mod-selector>

                        <div class="relative block mb-2 mt-4 mb-4">
                            {{ Form::checkbox('install', true, true, ['id' => 'install', 'class' => 'form-check-input']) }}
                            {{ Form::label('install', __('servers.install'), ['class' => 'form-check-label']) }}
                        </div>

                        <div class="md:w-1/3 pr-4 pl-4 md:mx-1/3">
                            <a class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded  no-underline bg-blue-600 text-white hover:bg-blue-600 py-1 px-2 leading-tight text-xs  btn-hide" data-bs-toggle="collapse" href="#additionalParameters" role="button" aria-expanded="false" aria-controls="additionalParameters">
                                <i class="far fa-caret-square-down"></i> {{ __('main.more') }}
                            </a>
                        </div>

                        <div class="hidden" id="additionalParameters">
                            <div class="mb-3{{ $errors->has('rcon') ? ' has-error' : '' }}">
                                {{ Form::label('rcon', null, ['class' => 'control-label']) }}

                                <div class="relative flex items-stretch w-full">
                                    {{ Form::input('password', 'rcon', null,
                                        ['class' => 'form-control password', 'autocomplete' => 'new-password']) }}
                                    <button class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline text-gray-600 border-gray-600 hover:bg-gray-600 hover:text-white bg-white hover:bg-gray-700 show-hide-password" type="button"><i class="far fa-eye"></i></button>
                                </div>
                            </div>

                            {{ Form::bsInput('text', [
                                'name' => 'dir',
                                'description' => __('servers.d_dir')
                            ]) }}

                            {{ Form::bsText('su_user', 'gameap') }}
                        </div>

                    </div>
                </div>
            </div>

            <div class="md:w-1/2 pr-4 pl-4">
                <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                        {{ __('servers.ds_ip_ports') }}
                    </div>
                    <div class="flex-auto p-6">
                        <ds-ip-selector :ds-list="{{ $dedicatedServers }}"></ds-ip-selector>
                        <smart-port-selector></smart-port-selector>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap  mt-2">
            <div class="md:w-full pr-4 pl-4">
                <div class="mb-3">
                    {{ Form::submit(__('main.create'), ['class' => 'btn btn-success']) }}
                </div>
            </div>
        </div>

    {!! Form::close() !!}
@endsection

@section('footer-scripts')
    <style>
        .btn-hide[aria-expanded="true"] {display: none;}
    </style>

    @include('scripts.formHelper')
@endsection

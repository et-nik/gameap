@php($title = __('client_certificates.title_create'))

@extends('layouts.main')

@section('breadcrumbs')
    <g-breadcrumbs :items="[
        {'link':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
        {'link':'{{ route("admin.dedicated_servers.index") }}', 'text':'{{ __("dedicated_servers.dedicated_servers") }}'},
        {'link':'{{ route("admin.client_certificates.index") }}', 'text':'{{ __("client_certificates.client_certificates") }}'},
        {'text':'{{ __("client_certificates.create") }}'},
    ]"></g-breadcrumbs>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.client_certificates.index'), 'files' => true]) !!}
        <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 bg-gray-100 mt-3 mb-3">
            <div class="flex-auto p-6">
                <div class="flex flex-wrap ">
                    <div class="md:w-full pr-4 pl-4">

                        <div class="flex flex-wrap ">
                            <div class="md:w-full pr-4 pl-4 mt-4 mb-3 pt-1">
                                <div class="relative flex items-stretch w-full" id="serverCertificateForm">
                                    {{ Form::file('certificate', ['class' => 'form-control']) }}
                                    {{ Form::label('certificate', __('client_certificates.certificate'), ['class' => 'input-group-text']) }}

                                    @if ($errors->has('certificate'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('certificate') }}</strong>
                                        </span>
                                    @endif

                                </div>
                            </div>

                            <div class="md:w-1/2 pr-4 pl-4 mt-4 mb-3 pt-1">
                                <div class="relative flex items-stretch w-full" id="serverCertificateForm">
                                    {{ Form::file('private_key', ['class' => 'form-control']) }}
                                    {{ Form::label('private_key', __('client_certificates.private_key'), ['class' => 'input-group-text']) }}

                                    @if ($errors->has('private_key'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('private_key') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="md:w-1/2 pr-4 pl-4">
                                {{ Form::bsPassword('private_key_pass') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:w-full mt-4 mb-8">
            <g-button color="green">
                <i class="fas fa-save"></i></i>&nbsp;{{ __('main.create') }}
            </g-button>
        </div>

    {!! Form::close() !!}

@endsection

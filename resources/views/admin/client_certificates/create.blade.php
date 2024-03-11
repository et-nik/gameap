@php($title = __('client_certificates.title_create'))

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700">
            <a href="{{ route('admin.dedicated_servers.index') }}">
                {{ __('dedicated_servers.dedicated_servers') }}
            </a>
        </li>
        <li class="inline-block px-2 py-2 text-gray-700">
            <a href="{{ route('admin.client_certificates.index') }}">
                {{ __('client_certificates.client_certificates') }}
            </a>
        </li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ __('client_certificates.create') }}</li>
    </ol>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.client_certificates.index'), 'files' => true]) !!}
        <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 bg-gray-100 mt-3 mb-3">
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

        <div class="flex flex-wrap ">
            <div class="md:w-full pr-4 pl-4">
                <div class="mb-3">
                    {{ Form::submit(__('main.create'), ['class' => 'btn btn-success']) }}
                </div>
            </div>
        </div>

    {!! Form::close() !!}

@endsection

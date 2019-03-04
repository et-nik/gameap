@php($title = __('client_certificates.title_create'))

@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dedicated_servers.index') }}">
                {{ __('dedicated_servers.dedicated_servers') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.client_certificates.index') }}">
                {{ __('client_certificates.client_certificates') }}
            </a>
        </li>
        <li class="breadcrumb-item active">{{ __('client_certificates.create') }}</li>
    </ol>
@endsection

{{-- TODO: Move filename fix --}}
@section('footer-scripts')
    <script>
        $(window).on('load',function(){
            $('.custom-file-input').on('change',function(){
                var fileName = $(this).val();
                fileName = fileName.replace(/^.*\\/, "");
                $(this).next('.custom-file-label').html(fileName);
            });
        });
    </script>
@endsection

@section('content')
    @include('components.form.errors_block')

    {!! Form::open(['url' => route('admin.client_certificates.index'), 'files' => true]) !!}
        <div class="card bg-light mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <div class="row">
                            <div class="col-12 mt-4 mb-3 pt-1">
                                <div class="custom-file" id="serverCertificateForm">
                                    {{ Form::file('certificate', ['class' => 'custom-file-input']) }}
                                    {{ Form::label('certificate', __('client_certificates.certificate'), ['class' => 'custom-file-label']) }}
    
                                    @if ($errors->has('certificate'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('certificate') }}</strong>
                                        </span>
                                    @endif
    
                                </div>
                            </div>

                            <div class="col-6 mt-4 mb-3 pt-1">
                                <div class="custom-file" id="serverCertificateForm">
                                    {{ Form::file('private_key', ['class' => 'custom-file-input']) }}
                                    {{ Form::label('private_key', __('client_certificates.private_key'), ['class' => 'custom-file-label']) }}

                                    @if ($errors->has('private_key'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('private_key') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-6">
                                {{ Form::bsPassword('private_key_pass') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    {{ Form::submit(__('main.create'), ['class' => 'btn btn-success']) }}
                </div>
            </div>
        </div>
    
    {!! Form::close() !!}

@endsection
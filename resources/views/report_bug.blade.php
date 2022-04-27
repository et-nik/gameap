@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item">{{ __('home.report_bug') }}</li>
    </ol>
@endsection

@section('content')
    <div class="card mb-2">
        <div class="card-header">
            {{ __('home.system_check') }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <p>
                        {{ __('home.d_report_bug') }}
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">PHP:</div>
                <div class="col-11">
                    <p>@php echo phpversion(); @endphp</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">GD:</div>
                <div class="col-md-11">
                    @if (in_array('gd', $extensions))
                        <p class="text-success"><i class="fas fa-check-circle"></i></p>
                    @else
                        <p class="text-danger"><i class="fas fa-times-circle"></i></p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">OpenSSL:</div>
                <div class="col-md-11">
                    @if (in_array('openssl', $extensions))
                        <p class="text-success"><i class="fas fa-check-circle"></i></p>
                    @else
                        <p class="text-danger"><i class="fas fa-times-circle"></i></p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">Curl:</div>
                <div class="col-md-11">
                    @if (in_array('curl', $extensions))
                        <p class="text-success"><i class="fas fa-check-circle"></i></p>
                    @else
                        <p class="text-danger"><i class="fas fa-times-circle"></i></p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">GMP:</div>
                <div class="col-md-11">
                    @if (in_array('gmp', $extensions))
                        <p class="text-success"><i class="fas fa-check-circle"></i></p>
                    @else
                        <p class="text-danger"><i class="fas fa-times-circle"></i></p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">Intl:</div>
                <div class="col-md-11">
                    @if (in_array('intl', $extensions))
                        <p class="text-success"><i class="fas fa-check-circle"></i></p>
                    @else
                        <p class="text-danger"><i class="fas fa-times-circle"></i></p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-2">
        <div class="card-header">
            {{ __('home.send_report') }}
        </div>
        <div class="card-body">
            {{ Form::open(['url' => route('send_bug'), 'style'=>'display:inline']) }}
                <div class="row">
                    <div class="col-md-12">
                        {{ Form::bsText('summary') }}
                        {{ Form::bsTextArea('description', null, null, ['rows' => 3]) }}
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            {{ Form::submit(__('main.send'), ['class' => 'btn btn-success']) }}
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection
@extends('layouts.main')

@section('breadclumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item">{{ __('home.report_bug') }}</li>
    </ol>
@endsection

@section('content')
    <p>Coming soon... Working on API in progress...</p>

    <div class="card mb-2">

        <div class="card-body">

            <div class="row">
                <div class="col-1">PHP:</div>
                <div class="col-10">
                    <p>@php echo phpversion(); @endphp</p>
                </div>
            </div>

            <div class="row">
                <div class="col-1">GD:</div>
                <div class="col-10">
                    @if (in_array('gd', $extensions))
                        <p class="text-success"><i class="fas fa-check-circle"></i></p>
                    @else
                        <p class="text-danger"><i class="fas fa-times-circle"></i></p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-1">OpenSSL:</div>
                <div class="col-10">
                    @if (in_array('openssl', $extensions))
                        <p class="text-success"><i class="fas fa-check-circle"></i></p>
                    @else
                        <p class="text-danger"><i class="fas fa-times-circle"></i></p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-1">Curl:</div>
                <div class="col-10">
                    @if (in_array('curl', $extensions))
                        <p class="text-success"><i class="fas fa-check-circle"></i></p>
                    @else
                        <p class="text-danger"><i class="fas fa-times-circle"></i></p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-1">GMP:</div>
                <div class="col-10">
                    @if (in_array('gmp', $extensions))
                        <p class="text-success"><i class="fas fa-check-circle"></i></p>
                    @else
                        <p class="text-danger"><i class="fas fa-times-circle"></i></p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-1">Intl:</div>
                <div class="col-10">
                    @if (in_array('intl', $extensions))
                        <p class="text-success"><i class="fas fa-check-circle"></i></p>
                    @else
                        <p class="text-danger"><i class="fas fa-times-circle"></i></p>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
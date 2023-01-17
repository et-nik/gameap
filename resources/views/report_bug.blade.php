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
                <div class="col-md-12">
                    <p>
                        {{ __('home.d_report_bug') }}
                    </p>
                </div>
            </div>

            <table class="table table-noborder table-fit">
                <tbody>
                <tr>
                    <td>PHP</td>
                    <td>@php echo phpversion(); @endphp</td>

                </tr>
                <tr>
                    <td>GD</td>
                    <td>
                        @if (in_array('gd', $extensions))
                            <span class="text-success"><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>OpenSSL</td>
                    <td>
                        @if (in_array('openssl', $extensions))
                            <span class="text-success"><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Curl</td>
                    <td>
                        @if (in_array('curl', $extensions))
                            <span class="text-success"><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>GMP</td>
                    <td>
                        @if (in_array('gmp', $extensions))
                            <span class="text-success"><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Intl</td>
                    <td>
                        @if (in_array('intl', $extensions))
                            <span class="text-success"><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>

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
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::submit(__('main.send'), ['class' => 'btn btn-success']) }}
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection

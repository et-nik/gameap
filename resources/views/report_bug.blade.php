@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700">{{ __('home.report_bug') }}</li>
    </ol>
@endsection

@section('content')
    <div class="flex flex-wrap ">

        <div class="w-full lg:w-1/2 pr-4 pl-4">
            <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mb-2">
                <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                    {{ __('home.system_check') }}
                </div>
                <div class="flex-auto p-6">
                    <div class="flex flex-wrap ">
                        <div class="md:w-full pr-4 pl-4">
                            <p>
                                {{ __('home.d_report_bug') }}
                            </p>
                        </div>
                    </div>

                    <table class="w-full max-w-full mb-4 bg-transparent table-noborder table-fit">
                        <tbody>
                        <tr>
                            <td>PHP</td>
                            <td>@php echo phpversion(); @endphp</td>

                        </tr>
                        <tr>
                            <td>GD</td>
                            <td>
                                @if (in_array('gd', $extensions))
                                    <span class="text-green-500"><i class="fas fa-check-circle"></i></span>
                                @else
                                    <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>OpenSSL</td>
                            <td>
                                @if (in_array('openssl', $extensions))
                                    <span class="text-green-500"><i class="fas fa-check-circle"></i></span>
                                @else
                                    <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Curl</td>
                            <td>
                                @if (in_array('curl', $extensions))
                                    <span class="text-green-500"><i class="fas fa-check-circle"></i></span>
                                @else
                                    <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>GMP</td>
                            <td>
                                @if (in_array('gmp', $extensions))
                                    <span class="text-green-500"><i class="fas fa-check-circle"></i></span>
                                @else
                                    <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Intl</td>
                            <td>
                                @if (in_array('intl', $extensions))
                                    <span class="text-green-500"><i class="fas fa-check-circle"></i></span>
                                @else
                                    <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 pr-4 pl-4">
            <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mb-2">
                <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900">
                    {{ __('home.send_report') }}
                </div>
                <div class="flex-auto p-6">
                    {{ Form::open(['url' => route('send_bug'), 'style'=>'display:inline']) }}
                        <div class="flex flex-wrap ">
                            <div class="md:w-full pr-4 pl-4">
                                {{ Form::bsText('summary') }}
                                {{ Form::bsTextArea('description', null, null, ['rows' => 3]) }}
                            </div>
                        </div>

                        <div class="flex flex-wrap  mt-2">
                            <div class="md:w-full pr-4 pl-4">
                                <div class="mb-3">
                                    {{ Form::submit(__('main.send'), ['class' => 'btn btn-success']) }}
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

    </div>
@endsection

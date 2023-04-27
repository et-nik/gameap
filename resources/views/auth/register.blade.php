@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card mb-3 mt-3">
                @if(config('app.allow_registration'))
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="card-header">{{ __('auth.sign_up') }}</div>

                        <div class="card-body">
                            <div class="mb-3{{ $errors->has('login') ? ' has-error' : '' }}">
                                <label for="login" class="col-md-12">{{ __('auth.login') }}</label>

                                <div class="col-md-12">
                                    <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required autofocus>

                                    @if ($errors->has('login'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('login') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-12">{{ __('auth.email') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-12">{{ __('auth.password') }}</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password-confirm" class="col-md-12">{{ __('auth.confirm_password') }}</label>

                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            @if(env('GOOGLE_RECAPTCHA_KEY'))
                                <div class="g-recaptcha"
                                     data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
                                </div>
                            @endif
                        </div>

                        <div class="card-footer">
                            <div class="mb-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-light">{{ __('auth.sign_up') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="card-body">
                        <p>{{ __('auth.registration_not_allowed') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

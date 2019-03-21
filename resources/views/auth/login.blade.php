@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card mb-3 mt-3">
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="card-header">{{ __('auth.sign_in') }}</div>

                    <div class="card-body">

                        <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                            <label for="login" class="col-md-12">{{ __('auth.username_email') }}</label>

                            <div class="col-md-12">
                                <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required autofocus>

                                @if ($errors->has('login'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
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

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('auth.remember') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-muted">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-light float-left">{{ __('auth.sign_in') }}</button>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <a class="btn btn-link float-left" href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
                                    </div>
                                    <div class="col-md-12">
                                        <a class="btn btn-link float-left" href="{{ route('register') }}">{{ __('auth.sign_up') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

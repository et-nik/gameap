@extends('layouts.guest')

@section('content')
<div class="container mx-auto sm:px-4">
    <div class="flex flex-wrap  justify-center mt-4">
        <div class="md:w-2/5 pr-4 pl-4">
            <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                @if(config('app.allow_registration'))
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900 p-6">{{ __('auth.sign_up') }}</div>

                        <div class="flex-auto p-6 p-6">
                            <div class="mb-3{{ $errors->has('login') ? ' has-error' : '' }}">
                                <label for="login" class="md:w-full pr-4 pl-4">{{ __('auth.login') }}</label>

                                <div class="md:w-full pr-4 pl-4">
                                    <input id="login" type="text" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="login" value="{{ old('login') }}" required autofocus>

                                    @if ($errors->has('login'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('login') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="md:w-full pr-4 pl-4">{{ __('auth.email') }}</label>

                                <div class="md:w-full pr-4 pl-4">
                                    <input id="email" type="email" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="md:w-full pr-4 pl-4">{{ __('auth.password') }}</label>

                                <div class="md:w-full pr-4 pl-4">
                                    <input id="password" type="password" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password-confirm" class="md:w-full pr-4 pl-4">{{ __('auth.confirm_password') }}</label>

                                <div class="md:w-full pr-4 pl-4">
                                    <input id="password-confirm" type="password" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="password_confirmation" required>
                                </div>
                            </div>

                            @if(env('GOOGLE_RECAPTCHA_KEY'))
                                <div class="g-recaptcha"
                                     data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
                                </div>
                            @endif
                        </div>

                        <div class="py-3 px-6 bg-gray-200 border-t-1 border-gray-300 p-6">
                            <div class="mb-3">
                                <div class="md:w-full pr-4 pl-4">
                                    <button type="submit" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-gray-100 text-gray-800 hover:bg-gray-200">{{ __('auth.sign_up') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="flex-auto p-6">
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

@extends('layouts.guest')

@section('content')
<div class="container mx-auto sm:px-4">
    <div class="flex flex-wrap  justify-center mt-4">
        <div class="md:w-2/5 pr-4 pl-4">
            <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900 p-6">{{ __('auth.reset_password') }}</div>

                    <div class="flex-auto p-6 p-6">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-3{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="md:w-1/3 pr-4 pl-4 control-label">{{ __('auth.email') }}</label>

                                <div class="md:w-1/2 pr-4 pl-4">
                                    <input id="email" type="email" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="email" value="{{ $email or old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="md:w-1/3 pr-4 pl-4 control-label">{{ __('auth.password') }}</label>

                                <div class="md:w-1/2 pr-4 pl-4">
                                    <input id="password" type="password" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="md:w-1/3 pr-4 pl-4 control-label">{{ __('auth.confirm_password') }}</label>
                                <div class="md:w-1/2 pr-4 pl-4">
                                    <input id="password-confirm" type="password" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                    </div>

                    <div class="py-3 px-6 bg-gray-200 border-t-1 border-gray-300 text-gray-700 p-6">
                        <div class="mb-3">
                            <div class="md:w-full pr-4 pl-4">
                                <button type="submit" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-gray-100 text-gray-800 hover:bg-gray-200">{{ __('auth.reset_password') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

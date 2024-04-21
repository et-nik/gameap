@extends('layouts.guest')

@section('content')
<div class="container mx-auto sm:px-4">
    <div class="flex flex-wrap  justify-center mt-4">
        <div class="md:w-2/5 pr-4 pl-4">
            <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 mb-3 mt-3">
                <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900 p-6">{{ __('auth.reset_password') }}</div>

                    <div class="flex-auto p-6">
                        @if (session('status'))
                            <div class="relative px-3 py-3 mb-4 border rounded bg-lime-200 border-green-300 text-green-800">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="mb-3{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="md:w-full pr-4 pl-4">{{ __('auth.username_email') }}</label>

                            <div class="md:w-full pr-4 pl-4">
                                <input id="email" type="email" class="block appearance-none w-full py-1 px-2 mb-1 leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="py-3 px-6 bg-gray-200 border-t-1 border-gray-300 text-gray-700 p-6">
                        <div class="mb-3">
                            <div class="md:w-full pr-4 pl-4">
                                <button type="submit" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline bg-gray-100 text-gray-800 hover:bg-gray-200">{{ __('auth.send_reset_link') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@php
    /**
     * @var array $abilities
     */
@endphp

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded">
        <li class="inline-block px-2 py-2 text-gray-700"><a href="/">GameAP</a></li>
        <li class="inline-block px-2 py-2 text-gray-700"><a href="{{ route('tokens') }}">{{ __('tokens.tokens') }}</a></li>
        <li class="inline-block px-2 py-2 text-gray-700 active">{{ __('tokens.generate_token') }}</li>
    </ol>
@endsection

@section('content')
    <div class="flex flex-wrap ">
        <div class="md:w-full pr-4 pl-4">
            <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 bg-gray-100 mt-3 mb-3">
                <div class="flex-auto p-6">
                    {!! Form::open(['url' => route('tokens.create')]) !!}
                    <div class="mb-3">
                        {{ Form::bsText('token_name') }}

                        <div class="flex flex-wrap ">
                            <div class="md:w-full pr-4 pl-4">
                                <div class="relative block mb-2">
                                    @foreach($abilities as $group => $groupAbilities)
                                        {{ Form::checkbox('abilities-' . $group, $group, false, [
                                            'id' => 'abilities-' . $group,
                                            'class' => 'ability-group form-check-input',
                                            'data-group' => $group,
                                        ]) }}
                                        {{ Form::label('abilities-'  . $group, $group, ['class' => 'form-check-label']) }}

                                        <ul id="list-abilities-{{ $group }}" style="list-style: none;">
                                            @foreach($groupAbilities as $ability => $description)
                                                <li class="mt-2">
                                                    <div class="flex flex-wrap ">
                                                        <div class="md:w-1/4 pr-4 pl-4">
                                                            {{ Form::checkbox(
                                                                'abilities[]',
                                                                $ability,
                                                                false,
                                                                ['id' => 'abilities-' . str_replace(':', '-', $ability), 'class' => 'form-check-input']
                                                            ) }}

                                                            {{ Form::label(
                                                                'abilities-' . str_replace(':', '-', $ability),
                                                                $ability,
                                                                ['class' => 'form-check-label']
                                                            ) }}
                                                        </div>

                                                        <div class="md:w-1/2 pr-4 pl-4">{{ $description }}</div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @if ($errors->has('abilities'))
                            <span class="help-block">
                                <strong class="text-red-600">{{ $errors->first('abilities') }}</strong>
                            </span>
                        @endif

                        @if ($errors->has('abilities.*'))
                            <span class="help-block">
                                <strong class="text-red-600">{{ $errors->first('abilities.*') }}</strong>
                            </span>
                        @endif
                    </div>
                    {{ Form::submit(__('main.save'), ['class' => 'btn btn-success btn-ico btn-ico-save']) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.ability-group').forEach(function(group) {
                group.addEventListener('change', function() {
                    const groupName = group.dataset.group;
                    const isChecked = group.checked;
                    const listSelector = '#list-abilities-' + groupName + ' input[type="checkbox"]';
                    document.querySelectorAll(listSelector).forEach(function(checkbox) {
                        checkbox.checked = isChecked;
                        checkbox.readOnly = isChecked;
                    });
                });
            });
        });
    </script>
@endsection

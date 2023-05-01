@php
    /**
     * @var array $abilities
     */
@endphp

@extends('layouts.main')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">GameAP</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tokens') }}">{{ __('tokens.tokens') }}</a></li>
        <li class="breadcrumb-item active">{{ __('tokens.generate_token') }}</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-light mt-3 mb-3">
                <div class="card-body">
                    {!! Form::open(['url' => route('tokens.create')]) !!}
                    <div class="mb-3">
                        {{ Form::bsText('token_name') }}

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check">
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
                                                    <div class="row">
                                                        <div class="col-md-3">
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

                                                        <div class="col-md-6">{{ $description }}</div>
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
                                <strong class="text-danger">{{ $errors->first('abilities') }}</strong>
                            </span>
                        @endif

                        @if ($errors->has('abilities.*'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('abilities.*') }}</strong>
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

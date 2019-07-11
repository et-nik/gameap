@php($title = __('modules.title'))

@extends('layouts.main')

@section('content')
    @include('components.form.errors_block')

    <a class='btn btn-success' href="{{ route('modules.migrate') }}"><i class="fas fa-redo"></i>&nbsp;{{ __('modules.migrate') }}</a>
    <hr>

    @include('components.grid', [
        'modelsList' => $modules,
        'labels' => [__('modules.name'), __('modules.description'), __('modules.keywords')],
        'attributes' => ['name', 'description', 'keywords'],
    ])
@endsection
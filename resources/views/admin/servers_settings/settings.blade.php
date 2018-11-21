@php($title = 'Game server settings')

@extends('layouts.main')

@section('content')
    <div class="col-md-6">
        {!! Form::model($server, ['method' => 'PATCH', 'route' => ['admin.servers_settings.update', $server->id], 'id' => 'adminServerForm']) !!}

        @foreach($settings as $setting)
            <div class="form-group">
                @if (strlen($setting->value) < 128)
                    {{ Form::bsText("value[{$setting->id}]", $setting->value, $setting->name) }}
                @else
                    {{ Form::bsTextArea("value[{$setting->id}]", $setting->value, $setting->name) }}
                @endif
            </div>
        @endforeach

        <div class="col-md-12">
            <div class="form-group">
                {{ Form::submit('Save', ['class' => 'btn btn-success']) }}
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection
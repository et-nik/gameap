@php($value = $value ?? null)
@php($label = $label ?? null)
@php($attributes = $attributes ?? [])

<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    {{ Form::label($name, $label, ['class' => 'control-label']) }}
    {{ Form::text($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}

    @if(isset($description))
        <small>{{ $description }}</small>
    @endif

    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
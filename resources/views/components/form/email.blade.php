@if (empty($label))
    @php ($localeLabel = __('labels.' . $name))
    @if (!empty($localeLabel) && $localeLabel != 'labels.' . $name)
        @php ($label = $localeLabel)
    @endif
@endif

<div class="mb-3{{ $errors->has($name) ? ' has-error' : '' }}">
    {{ Form::label($name, $label, ['class' => 'control-label']) }}
    {{ Form::email($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}

    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>

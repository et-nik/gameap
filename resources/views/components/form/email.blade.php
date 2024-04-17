@if (empty($label))
    @php ($localeLabel = __('labels.' . $name))
    @if (!empty($localeLabel) && $localeLabel != 'labels.' . $name)
        @php ($label = $localeLabel)
    @endif
@endif

<div class="mb-3{{ $errors->has($name) ? ' has-error' : '' }}">
    {{ Form::label($name, $label, ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white']) }}
    {{ Form::email($name, $value, array_merge(['class' => 'block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded'], $attributes)) }}

    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>

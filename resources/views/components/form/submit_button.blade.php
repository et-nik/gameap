@php
/**
 * @var $options array
 * @var $id string
 * @var $route string
 * @var $method string|null
 * @var $data array
 * @var $icon string|null
 * @var $text string
 * @var $class string
 * @var $confirmAction string
 * @var $confirmMessage string
**/

extract($options, EXTR_OVERWRITE);

$icon = $icon ?? '';
$class = $class ?? 'btn btn-primary btn-sm';
$confirmMessage = $confirmMessage ?? __('main.confirm_message');
@endphp

{{ Form::open([
    'id' => $id,
    'url' => $route,
    'style'=>'display:inline'
])}}

@if (isset($method))
    {{ Form::hidden('_method', $method) }}
@endif

@foreach ($data as $key => $value)
    {{ Form::hidden($key, $value) }}
@endforeach

{{ Form::button( $icon . '<span class="d-none d-xl-inline">&nbsp;' . $text . '</span>',
    [
        'class'      => $class,
        'title'      => __('main.delete'),
        'v-on:click' => $confirmAction ?? 'confirmAction($event, \'' . __($confirmMessage). '\')',
        'type'       => 'submit'
    ]
    ) }}

{{ Form::close() }}

@php
/**
 * @var $modelsList array
 * @var $labels array
 * @var $attributes array
 * @var $customActionsBefore callable|null
 * @var $viewRoute string|null
 * @var $editRoute string|null
 * @var $destroyRoute string|null
**/

$showActionCollumn = isset($customActionsBefore) || isset($viewRoute) || isset($editRoute) || isset($destroyRoute);
@endphp

<table class="table table-striped table-bordered table-grid-models">
    <thead>
    <tr>
        @foreach ($labels as $label)
            <th>{{ $label }}</th>
        @endforeach

        @if ($showActionCollumn)
            <th class="w-10">{{ __('main.actions') }}</th>
        @endif
    </tr>
    </thead>

    <tbody>
        @foreach($modelsList as $key => $model)

            @if (is_object($model) && method_exists($model, 'getKey'))
                @php($modelKey = $model->getKey())
            @elseif ((is_array($model) && array_key_exists('id', $model)) || (is_object($model) && property_exists($model, 'id')))
                @php ($modelKey = is_array($model) ? $model['id'] : $model->id)
            @endif

            <tr>
                @foreach ($attributes as $attr)
                    @php($cellValue = '')

                    {{--Get Cell value--}}
                    @if (is_array($attr))
                        @php ($type = $attr[0])
                        @php ($params = $attr[1])

                        @if ($type == 'raw')
                            @php($cellValue = $params)
                        @elseif ($type == 'lambda')
                            @php($cellValue = $params($model))
                        @elseif ($type == 'twoSeparatedValues')
                            @php($cellValue = $model->{$params[0]} . $params[1] . $model->{$params[2]})
                        @endif
                    @elseif (is_string($attr))
                        @if (is_array($model))
                            @php($model = (object)$model)
                        @endif

                        @if (is_array($model->{$attr}))
                            @foreach ($model->{$attr} as $val)
                                @php($cellValue .= "<p>{$val}</p>")
                            @endforeach
                        @else
                            @if(strpos($attr, '.') !== false)
                                @php($ex = explode('.', $attr, 2))

                                @if (isset($model->{$ex[0]}))
                                    @php($cellValue = $model->{$ex[0]}->{$ex[1]})
                                @else
                                    @php($cellValue = '')
                                @endif
                            @else
                                @php($cellValue = $model->{$attr})
                            @endif
                        @endif
                    @endif


                    @if($cellValue instanceof \Carbon\Carbon)
                        <td>{!! \Gameap\Helpers\DateHelper::convertToLocal($cellValue) !!}</td>
                    @else
                        <td>{!! $cellValue !!}</td>
                    @endif

                @endforeach

                @if (isset($modelKey) && $showActionCollumn)
                    <td class="text-nowrap">
                            @if (isset($customActionsBefore))
                                {!! $customActionsBefore($modelKey, $model) !!}
                            @endif

                            @if (isset($viewRoute))
                                <a class="btn btn-small btn-success btn-sm btn-view"
                                   title="{{ __('main.view') }}"
                                   href="{{ route($viewRoute, $modelKey) }}">
                                    <i class="fas fa-eye"></i><span class="d-none d-xl-inline">&nbsp;{{ __('main.view') }}</span>
                                </a>&nbsp;
                            @endif

                            @if (isset($editRoute))
                                <a class="btn btn-small btn-info btn-sm btn-edit"
                                   title="{{ __('main.edit') }}"
                                   href="{{ route($editRoute, $modelKey) }}">
                                    <i class="fas fa-edit"></i><span class="d-none d-xl-inline">&nbsp;{{ __('main.edit') }}</span>
                                </a>&nbsp;
                            @endif

                            @if (isset($destroyRoute))
                                {{ Form::open(['id' => 'form-destroy-' . $modelKey, 'url' => route($destroyRoute, $modelKey), 'style'=>'display:inline']) }}
                                {{ Form::hidden('_method', 'DELETE') }}

                                {{ Form::button( '<i class="fas fa-trash"></i><span class="d-none d-xl-inline">&nbsp;' . __('main.delete') . '</span>',
                                    [
                                        'class' => 'btn btn-danger btn-sm btn-delete',
                                        'title' => __('main.delete'),
                                        'v-on:click' => $destroyConfirmAction ?? 'confirmAction($event, \'' . __('main.confirm_message'). '\')',
                                        'type' => 'submit'
                                    ]
                                    ) }}

                                {{ Form::close() }}
                            @endif
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

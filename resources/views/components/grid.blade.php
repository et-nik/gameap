<table class="table table-striped table-bordered">
    <thead>
    <tr>
        @foreach ($labels as $label)
            <td>{{ $label }}</td>
        @endforeach

        @if (isset($viewRoute) || isset($editRoute) || isset($destroyRoute))
            <td>{{ __('main.actions') }}</td>
        @endif
    </tr>
    </thead>

    <tbody>
        @foreach($modelsList as $key => $model)

            @if (method_exists($model, 'getKey'))
                @php($modelKey = $model->getKey())
            @elseif (array_key_exists('id', $model))
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

                    <td>{!! $cellValue !!}</td>
                @endforeach

                @if (isset($modelKey) && isset($viewRoute) || isset($editRoute) || isset($destroyRoute))
                    <td class="text-nowrap">
                            @if (isset($viewRoute))
                                <a class="btn btn-small btn-success btn-sm btn-view"
                                   title="{{ __('main.view') }}"
                                   href="{{ route($viewRoute, $modelKey) }}">

                                    <i class="fas fa-eye"></i> <span class="d-none d-xl-inline">&nbsp;{{ __('main.view') }}</span>
                                </a>
                            @endif

                            @if (isset($editRoute))
                                <a class="btn btn-small btn-info btn-sm btn-edit"
                                   title="{{ __('main.edit') }}"
                                   href="{{ route($editRoute, $modelKey) }}">

                                    <i class="fas fa-edit"></i><span class="d-none d-xl-inline">&nbsp;{{ __('main.edit') }}</span>
                                </a>
                            @endif

                            @if (isset($destroyRoute))
                                {{ Form::open(['id' => 'form-destroy-' . $modelKey, 'url' => route($destroyRoute, $modelKey), 'style'=>'display:inline']) }}
                                {{ Form::hidden('_method', 'DELETE') }}

                                {{ Form::button( '<i class="fas fa-trash"></i><span class="d-none d-xl-inline">&nbsp;' . __('main.delete') . '</span>',
                                    [
                                        'class' => 'btn btn-danger btn-sm btn-delete',
                                        'title' => __('main.delete'),
                                        'v-on:click' => !isset($destroyConfirmAction)
                                            ? 'confirmAction($event, \'' . __('main.confirm_message'). '\')'
                                            : $destroyConfirmAction,
                                        'type' => 'submit'
                                    ]
                                    ) }}

                                {{ Form::close() }}
                            @endif
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
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
                        @if (is_array($model->{$attr}))
                            @foreach ($model->{$attr} as $val)
                                @php($cellValue .= "<p>{$val}</p>")
                            @endforeach
                        @else
                            @if(strpos($attr, '.') !== false)
                                @php($ex = explode('.', $attr, 2))
                                @php($cellValue = $model->{$ex[0]}->{$ex[1]})
                            @else
                                @php($cellValue = $model->{$attr})
                            @endif
                        @endif
                    @endif

                    <td>{!! $cellValue !!}</td>
                @endforeach

                @if (isset($viewRoute) || isset($editRoute) || isset($destroyRoute))
                    <td>
                        @if (isset($viewRoute))
                            <a class="btn btn-small btn-success btn-sm" href="{{ route($viewRoute, $model->getKey()) }}">{{ __('main.view') }}</a>
                        @endif

                        @if (isset($editRoute))
                            <a class="btn btn-small btn-info btn-sm" href="{{ route($editRoute, $model->getKey()) }}">{{ __('main.edit') }}</a>
                        @endif

                        @if (isset($destroyRoute))
                            {{ Form::open(['url' => route($destroyRoute, $model->getKey()), 'style'=>'display:inline']) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit( __('main.delete'), ['class' => 'btn btn-danger btn-sm', 'v-on:click' => 'confirmAction($event, \'Are you sure?\')']) }}
                            {{ Form::close() }}
                        @endif
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        @foreach ($labels as $label)
            <td>{{ $label }}</td>
        @endforeach

        @if (isset($viewRoute) || isset($editRoute) || isset($destroyRoute))
            <td>Actions</td>
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
                        @php($cellValue = $model->{$attr[0]} . $attr[1] . $model->{$attr[2]})
                    @elseif (is_string($attr))
                        @if (is_array($model->{$attr}))
                            @foreach ($model->{$attr} as $val)
                                @php($cellValue .= "<p>{$val}</p>")
                            @endforeach
                        @else
                            @php($cellValue = $model->{$attr})
                        @endif
                    @endif

                    <td>{!! $cellValue !!}</td>
                @endforeach

                @if (isset($viewRoute) || isset($editRoute) || isset($destroyRoute))
                    <td>
                        @if (isset($viewRoute))
                            <a class="btn btn-small btn-success btn-sm" href="{{ route($viewRoute, $model->getKey()) }}">View</a>
                        @endif

                        @if (isset($editRoute))
                            <a class="btn btn-small btn-info btn-sm" href="{{ route($editRoute, $model->getKey()) }}">Edit</a>
                        @endif

                        @if (isset($destroyRoute))
                            {{ Form::open(array('url' => route($destroyRoute, $model->getKey()), 'style'=>'display:inline')) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-warning btn-sm')) }}
                            {{ Form::close() }}
                        @endif
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>